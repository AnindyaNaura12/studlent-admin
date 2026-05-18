<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class EscrowModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    public function getAllEscrows($search = '', $status = '') {
        $query = 'select=id_escrow,id_payment,amount,platform_fee,freelancer_amount,status,released_at,created_at,updated_at&order=created_at.desc';

        if ($status !== '') $query .= '&status=eq.' . urlencode($status);
        if ($search !== '') $query .= '&id_payment=ilike.*' . urlencode($search) . '*';

        $result = $this->client->get('escrow', $query);
        return (is_array($result) && !isset($result['code'])) ? $result : [];
    }

    public function getEscrowById($id) {
        $result = $this->client->get('escrow', 'select=*&id_escrow=eq.' . urlencode($id) . '&limit=1');
        if (is_array($result) && !isset($result['code']) && !empty($result)) {
            return $result[0];
        }
        return null;
    }

    public function countByStatus() {
        $statuses = ['held', 'released', 'refunded'];
        $counts = [];
        foreach ($statuses as $status) {
            $result = $this->client->get('escrow', 'select=id_escrow&status=eq.' . $status);
            $counts[$status] = (is_array($result) && !isset($result['code'])) ? count($result) : 0;
        }
        return $counts;
    }

    public function getSummary() {
        $all = $this->client->get('escrow', 'select=amount,platform_fee,freelancer_amount,status');
        if (!is_array($all) || isset($all['code'])) $all = [];

        $held     = array_filter($all, fn($r) => $r['status'] === 'held');
        $released = array_filter($all, fn($r) => $r['status'] === 'released');

        return [
            'total_held'            => array_sum(array_column(array_values($held), 'amount')),
            'total_released'        => array_sum(array_column(array_values($released), 'amount')),
            'total_platform_fee'    => array_sum(array_column($all, 'platform_fee')),
            'total_freelancer'      => array_sum(array_column(array_values($released), 'freelancer_amount')),
        ];
    }
}