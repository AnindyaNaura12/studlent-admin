<?php
class SupabaseClient {
    private $url;
    private $key;

    public function __construct() {
        $this->url = SUPABASE_URL;
        $this->key = SUPABASE_KEY;
    }

    public function get($table, $query = '') {
        $endpoint = $this->url . '/rest/v1/' . $table . '?' . $query;
        return $this->request('GET', $endpoint);
    }

    private function request($method, $endpoint, $body = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'apikey: ' . $this->key,
            'Authorization: Bearer ' . $this->key,
            'Content-Type: application/json'
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        }

        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}