<?php
require_once BASE_PATH . '/core/Controller.php';

class DashboardController extends Controller {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/DashboardModel.php';
        $this->model = new DashboardModel();
    }

    public function index() {
        $data = [
            'title'               => 'Dashboard - Studlent',
            'totalUsers'          => $this->model->getTotalUsers(),
            'totalFreelancers'    => $this->model->getTotalFreelancers(),
            'totalOrders'         => $this->model->getTotalOrders(),
            'totalRevenue'        => $this->model->getTotalRevenue(),
            'totalServices'       => $this->model->getTotalServices(),
            'pendingWithdrawals'  => $this->model->getPendingWithdrawals(),
            'ordersByStatus'      => $this->model->getOrdersByStatus(),
            'recentOrders'        => $this->model->getRecentOrders(),
            'recentUsers'         => $this->model->getRecentUsers(),
        ];

        $this->view('pages/dashboard', $data);
    }
}