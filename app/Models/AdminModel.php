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
}