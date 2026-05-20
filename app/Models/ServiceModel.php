<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class ServiceModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    // ─────────────────────────────────────────────
    // GET ALL SERVICES
    // ─────────────────────────────────────────────
    public function getAllServices($search = '', $status = '', $category = '') {

        $query = 'select=id_service,id_freelancer,id_category,judul,deskripsi,thumbnail_url,status,rating_avg,total_order,created_at&order=created_at.desc';

        if ($status !== '') {
            $query .= '&status=eq.' . urlencode($status);
        }

        if ($category !== '') {
            $query .= '&id_category=eq.' . urlencode($category);
        }

        if ($search !== '') {
            $query .= '&judul=ilike.*' . urlencode($search) . '*';
        }

        $result = $this->client->get('services', $query);

        return (is_array($result) && !isset($result['code']))
            ? $result
            : [];
    }

    // ─────────────────────────────────────────────
    // GET SERVICE BY ID
    // ─────────────────────────────────────────────
    public function getServiceById($id) {

        $result = $this->client->get(
            'services',
            'select=*&id_service=eq.' . urlencode($id) . '&limit=1'
        );

        if (
            is_array($result) &&
            !isset($result['code']) &&
            !empty($result)
        ) {
            return $result[0];
        }

        return null;
    }

    // ─────────────────────────────────────────────
    // GET PACKAGES
    // ─────────────────────────────────────────────
    public function getPackagesByService($id) {

        $result = $this->client->get(
            'service_packages',
            'select=*&id_service=eq.' . urlencode($id)
        );

        return (is_array($result) && !isset($result['code']))
            ? $result
            : [];
    }

    // ─────────────────────────────────────────────
    // GET IMAGES
    // ─────────────────────────────────────────────
    public function getImagesByService($id) {

        $result = $this->client->get(
            'service_images',
            'select=*&id_service=eq.' . urlencode($id)
        );

        return (is_array($result) && !isset($result['code']))
            ? $result
            : [];
    }

    // ─────────────────────────────────────────────
    // GET CATEGORIES
    // ─────────────────────────────────────────────
    public function getAllCategories() {

        $result = $this->client->get(
            'service_categories',
            'select=id_category,nama&order=nama.asc'
        );

        return (is_array($result) && !isset($result['code']))
            ? $result
            : [];
    }

    // ─────────────────────────────────────────────
    // COUNT STATUS
    // ─────────────────────────────────────────────
    public function countByStatus() {

        $statuses = ['active', 'inactive', 'pending', 'rejected'];

        $counts = [];

        foreach ($statuses as $status) {

            $result = $this->client->get(
                'services',
                'select=id_service&status=eq.' . $status
            );

            $counts[$status] =
                (is_array($result) && !isset($result['code']))
                ? count($result)
                : 0;
        }

        return $counts;
    }

    // ─────────────────────────────────────────────
    // UPDATE STATUS + SEND NOTIFICATION
    // ─────────────────────────────────────────────
    public function updateStatus($id, $status) {

        $endpoint =
            SUPABASE_URL .
            '/rest/v1/services?id_service=eq.' .
            urlencode($id);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'status' => $status
        ]));

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'apikey: ' . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
            'Content-Type: application/json',
            'Prefer: return=minimal'
        ]);

        $response = curl_exec($ch);
        

        // Debug kalau error
        //if (curl_errno($ch)) {
          //  die('Curl Error: ' . curl_error($ch));
        //}

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        // ─────────────────────────────────────
        // JIKA BERHASIL → KIRIM NOTIF
        // ─────────────────────────────────────
        if ($httpCode === 204) {

            $service = $this->getServiceById($id);

            if ($service) {

                $message = '';

                if ($status === 'active') {
                    $message = 'Service kamu telah disetujui admin';
                }

                if ($status === 'rejected') {
                    $message = 'Service kamu ditolak admin';
                }

                if ($status === 'inactive') {
                    $message = 'Service kamu dinonaktifkan admin';
                }

                // INSERT NOTIF
                if ($message !== '') {

                    $this->client->post('notifications', [
                        'id_user'   => $service['id_freelancer'],
                        'title'     => 'Update Service',
                        'message'   => $message,
                        'created_at'=> date('c')
                    ]);
                }
            }
        }

        return in_array($httpCode, [200, 204]);
    }
}