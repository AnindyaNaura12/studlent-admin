<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class OrderModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    public function getAllOrders($search = '', $status = '') {
        $query = 'select=id_order,id_client,id_freelancer,id_service,id_package,detail_pesanan,catatan,deadline,progress,status,created_at,updated_at&order=created_at.desc';

        if ($status !== '') $query .= '&status=eq.' . urlencode($status);
        if ($search !== '') $query .= '&or=(id_client.ilike.*' . urlencode($search) . '*,id_freelancer.ilike.*' . urlencode($search) . '*)';

        $result = $this->client->get('orders', $query);
        return (is_array($result) && !isset($result['code'])) ? $result : [];
    }

    public function getOrderById($id) {
        $result = $this->client->get('orders', 'select=*&id_order=eq.' . urlencode($id) . '&limit=1');
        if (is_array($result) && !isset($result['code']) && !empty($result)) {
            return $result[0];
        }
        return null;
    }

    public function countByStatus() {
        $statuses = ['pending', 'active', 'completed', 'cancelled'];
        $counts = [];
        foreach ($statuses as $status) {
            $result = $this->client->get('orders', 'select=id_order&status=eq.' . $status);
            $counts[$status] = (is_array($result) && !isset($result['code'])) ? count($result) : 0;
        }
        return $counts;
    }

    public function updateStatus($id, $status) {
        $endpoint = SUPABASE_URL . '/rest/v1/orders?id_order=eq.' . urlencode($id);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['status' => $status]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'apikey: ' . SUPABASE_KEY,
            'Authorization: Bearer ' . SUPABASE_KEY,
            'Content-Type: application/json',
            'Prefer: return=minimal'
        ]);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode === 204;
    }
}