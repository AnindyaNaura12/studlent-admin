<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class AdminModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    public function findByEmail($email) {
        $result = $this->client->get('admins', 'email=eq.' . urlencode($email) . '&limit=1');
        return $result[0] ?? null;
    }

    public function findById($id) {
        $result = $this->client->get('admins', 'select=*&id=eq.' . urlencode($id) . '&limit=1');
        if (is_array($result) && !isset($result['code']) && !empty($result)) {
            return $result[0];
        }
        return null;
    }

    public function updateProfile($id, $data) {
        $endpoint = SUPABASE_URL . '/rest/v1/admins?id=eq.' . urlencode($id);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
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