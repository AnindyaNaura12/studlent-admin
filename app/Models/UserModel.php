<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class UserModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    public function getAllUsers($search = '', $role = '', $status = '') {
        $query = 'select=id_user,nama,username,email,no_hp,role,is_active,joined_at,foto,professional_status';

        $filters = [];
        if ($role !== '')   $filters[] = 'role=eq.' . urlencode($role);
        if ($status !== '') $filters[] = 'is_active=eq.' . $status;
        if ($search !== '') $filters[] = 'or=(nama.ilike.*' . urlencode($search) . '*,email.ilike.*' . urlencode($search) . '*,username.ilike.*' . urlencode($search) . '*)';

        if ($filters) $query .= '&' . implode('&', $filters);
        $query .= '&order=created_at.desc';

        $result = $this->client->get('users', $query);
        return (is_array($result) && !isset($result['code'])) ? $result : [];
    }

    public function getUserById($id) {
        $result = $this->client->get('users', 'select=*&id_user=eq.' . urlencode($id) . '&limit=1');
        if (is_array($result) && !isset($result['code']) && !empty($result)) {
            return $result[0];
        }
        return null;
    }

    public function toggleActive($id, $currentStatus) {
        $newStatus = $currentStatus ? 'false' : 'true';
        $endpoint  = SUPABASE_URL . '/rest/v1/users?id_user=eq.' . urlencode($id);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['is_active' => $newStatus === 'true']));
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

    public function countByRole() {
        $roles  = ['client', 'freelancer', 'admin'];
        $counts = [];
        foreach ($roles as $role) {
            $result       = $this->client->get('users', 'select=id_user&role=eq.' . $role);
            $counts[$role] = (is_array($result) && !isset($result['code'])) ? count($result) : 0;
        }
        return $counts;
    }
}