<?php
require_once BASE_PATH . '/core/SupabaseClient.php';

class DashboardModel {
    private $client;

    public function __construct() {
        $this->client = new SupabaseClient();
    }

    public function getRecentOrders() {
        return $this->client->get('orders', 'select=id_orders,status,created_at&order=created_at.desc&limit=5');
    }

    public function getRecentUsers() {
        return $this->client->get('users', 'select=id_user,full_name,email,created_at&order=created_at.desc&limit=5');
    }

    public function getTotalUsers() {
        $result = $this->client->get('users', 'select=id_user');
        return is_array($result) ? count($result) : 0;
    }

    public function getTotalFreelancers() {
        $result = $this->client->get('freelancer_profiles', 'select=id_user');
        return is_array($result) ? count($result) : 0;
    }

    public function getTotalOrders() {
        $result = $this->client->get('orders', 'select=id_orders');
        return is_array($result) ? count($result) : 0;
    }

    public function getTotalServices() {
        $result = $this->client->get('services', 'select=id_orders');
        return is_array($result) ? count($result) : 0;
    }

    public function getPendingWithdrawals() {
        $result = $this->client->get('withdrawals', 'select=id_user&status=eq.pending');
        return is_array($result) ? count($result) : 0;
    }

    public function getTotalRevenue() {
        $result = $this->client->get('payments', 'select=amount&status=eq.completed');
        if (!is_array($result)) return 0;
        // Cek kalau hasilnya error dari Supabase
        if (isset($result['code'])) return 0;
        return array_sum(array_column($result, 'amount'));
    }

    public function getOrdersByStatus() {
        $statuses = ['pending', 'active', 'completed', 'cancelled'];
        $data = [];
        foreach ($statuses as $status) {
            $result = $this->client->get('orders', 'select=id_orders&status=eq.' . $status);
            $data[$status] = (is_array($result) && !isset($result['code'])) ? count($result) : 0;
        }
        return $data;
    }
}