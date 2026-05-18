<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class PaymentModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    public function getAllPayments($search = '', $status = '', $escrow = '') {
        $query = 'select=id_payment,id_order,metode,amount,admin_fee,status,escrow_status,platform_fee,freelancer_receive,tanggal_bayar,created_at&order=created_at.desc';

        if ($status !== '') $query .= '&status=eq.' . urlencode($status);
        if ($escrow !== '') $query .= '&escrow_status=eq.' . urlencode($escrow);
        if ($search !== '') $query .= '&or=(metode.ilike.*' . urlencode($search) . '*,id_order.ilike.*' . urlencode($search) . '*)';

        $result = $this->client->get('payments', $query);
        return (is_array($result) && !isset($result['code'])) ? $result : [];
    }

    public function getPaymentById($id) {
        $result = $this->client->get('payments', 'select=*&id_payment=eq.' . urlencode($id) . '&limit=1');
        if (is_array($result) && !isset($result['code']) && !empty($result)) {
            return $result[0];
        }
        return null;
    }

    public function countByStatus() {
        $statuses = ['pending', 'paid', 'failed', 'expired'];
        $counts = [];
        foreach ($statuses as $status) {
            $result = $this->client->get('payments', 'select=id_payment&status=eq.' . $status);
            $counts[$status] = (is_array($result) && !isset($result['code'])) ? count($result) : 0;
        }
        return $counts;
    }

    public function getSummary() {
        $paid = $this->client->get('payments', 'select=amount,admin_fee,platform_fee,freelancer_receive&status=eq.paid');
        if (!is_array($paid) || isset($paid['code'])) $paid = [];

        return [
            'total_revenue'    => array_sum(array_column($paid, 'amount')),
            'total_fee'        => array_sum(array_column($paid, 'admin_fee')),
            'total_platform'   => array_sum(array_column($paid, 'platform_fee')),
            'total_freelancer' => array_sum(array_column($paid, 'freelancer_receive')),
        ];
    }
}