<?php
require_once BASE_PATH . '/core/Controller.php';

class PaymentController extends Controller {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/PaymentModel.php';
        $this->model = new PaymentModel();
    }

    public function index() {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');
        $escrow = trim($_GET['escrow'] ?? '');

        $data = [
            'title'        => 'Payments - Studlent',
            'payments'     => $this->model->getAllPayments($search, $status, $escrow),
            'statusCounts' => $this->model->countByStatus(),
            'summary'      => $this->model->getSummary(),
            'search'       => $search,
            'status'       => $status,
            'escrow'       => $escrow,
        ];

        $this->view('pages/payments', $data);
    }

    public function detail() {
        $id      = $_GET['id'] ?? null;
        $payment = $id ? $this->model->getPaymentById($id) : null;

        if (!$payment) {
            header('Location: ' . BASE_URL . 'payment');
            exit;
        }

        $this->view('pages/payment_detail', [
            'title'   => 'Detail Payment - Studlent',
            'payment' => $payment,
        ]);
    }
}