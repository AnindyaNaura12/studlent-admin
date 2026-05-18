<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class WithdrawalModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    public function getAllWithdrawals($search = '', $status = '') {
        $query = 'select=id_withdraw,id_user,amount,no_rekening,bank_name,status,created_at,updated_at&order=created_at.desc';

        if ($status !== '') $query .= '&status=eq.' . urlencode($status);
        if ($search !== '') $query .= '&or=(bank_name.ilike.*' . urlencode($search) . '*,no_rekening.ilike.*' . urlencode($search) . '*)';

        $result = $this->client->get('withdrawals', $query);
        return (is_array($result) && !isset($result['code'])) ? $result : [];
    }

    public function getWithdrawalById($id) {
        $result = $this->client->get('withdrawals', 'select=*&id_withdraw=eq.' . urlencode($id) . '&limit=1');
        if (is_array($result) && !isset($result['code']) && !empty($result)) {
            return $result[0];
        }
        return null;
    }

    public function countByStatus() {
        $statuses = ['pending', 'approved', 'rejected'];
        $counts = [];
        foreach ($statuses as $status) {
            $result = $this->client->get('withdrawals', 'select=id_withdraw&status=eq.' . $status);
            $counts[$status] = (is_array($result) && !isset($result['code'])) ? count($result) : 0;
        }
        return $counts;
    }

    public function getTotalAmount($status = 'approved') {
        $result = $this->client->get('withdrawals', 'select=amount&status=eq.' . $status);
        if (!is_array($result) || isset($result['code'])) return 0;
        return array_sum(array_column($result, 'amount'));
    }

    public function updateStatus($id, $status) {
        $endpoint = SUPABASE_URL . '/rest/v1/withdrawals?id_withdraw=eq.' . urlencode($id);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'status'     => $status,
            'updated_at' => date('c'),
        ]));
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