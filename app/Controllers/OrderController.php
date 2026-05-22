<?php
require_once BASE_PATH . '/core/Controller.php';

class OrderController extends Controller {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/OrderModel.php';
        $this->model = new OrderModel();
    }

    public function index() {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $data = [
            'title'        => 'Orders - Studlent',
            'orders'       => $this->model->getAllOrders($search, $status),
            'statusCounts' => $this->model->countByStatus(),
            'search'       => $search,
            'status'       => $status,
        ];

        $this->view('pages/orders', $data);
    }

    public function detail() {
        $id = $_GET['id'] ?? null;
        $order = $id ? $this->model->getOrderById($id) : null;

        if (!$order) {
            header('Location: ' . BASE_URL . 'order');
            exit;
        }

        $this->view('pages/order_detail', [
            'title' => 'Detail Order - Studlent',
            'order' => $order,
        ]);
    }

    public function updatestatus() {
        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;

        $allowed = ['pending', 'active', 'completed', 'cancelled'];
        if ($id && in_array($status, $allowed)) {
            $this->model->updateStatus($id, $status);
        }

        header('Location: ' . BASE_URL . 'order');
        exit;
    }
}