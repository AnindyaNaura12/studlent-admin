<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class DashboardModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    private function safeCount($result) {
        if (!is_array($result) || isset($result['error']) || isset($result['code'])) return 0;
        return count($result);
    }

    public function getTotalUsers() {
        return $this->safeCount(
            $this->client->get('users', 'select=id_user&role=neq.admin')
        );
    }

    public function getTotalFreelancers() {
        return $this->safeCount(
            $this->client->get('freelancer_profiles', 'select=id_profile')
        );
    }

    public function getTotalOrders() {
        return $this->safeCount(
            $this->client->get('orders', 'select=id_order')
        );
    }

    public function getTotalServices() {
        return $this->safeCount(
            $this->client->get('services', 'select=id_service')
        );
    }

    public function getPendingWithdrawals() {
        return $this->safeCount(
            $this->client->get('withdrawals', 'select=id_withdraw&status=eq.pending')
        );
    }

    public function getTotalRevenue() {
        $result = $this->client->get('payments', 'select=amount&status=eq.paid');
        if (!is_array($result) || isset($result['error'])) return 0;
        return array_sum(array_column($result, 'amount'));
    }

    public function getOrdersByStatus() {
        // Sesuai CHECK constraint di schema kamu
        $statuses = [
            'menunggu_pembayaran',
            'paid',
            'diproses',
            'hasil_dikirim',
            'revisi',
            'selesai',
            'dibatalkan'
        ];
        $data = [];
        foreach ($statuses as $status) {
            $result = $this->client->get('orders', 'select=id_order&status=eq.' . $status);
            $data[$status] = $this->safeCount($result);
        }
        return $data;
    }

    public function getRecentOrders() {
        $result = $this->client->get(
            'orders',
            'select=id_order,status,created_at&order=created_at.desc&limit=5'
        );
        // Pastikan return array of arrays, bukan null/error
        if (!is_array($result) || isset($result['error']) || isset($result['code'])) {
            return [];
        }
        return $result;
    }

    public function getRecentUsers() {
        $result = $this->client->get(
            'users',
            'select=id_user,nama,email,created_at&order=created_at.desc&limit=5'
        );
        if (!is_array($result) || isset($result['error']) || isset($result['code'])) {
            return [];
        }
        return $result;
    }
}