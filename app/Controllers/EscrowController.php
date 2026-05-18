<?php
require_once BASE_PATH . '/core/Controller.php';

class EscrowController extends Controller {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/EscrowModel.php';
        $this->model = new EscrowModel();
    }

    public function index() {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $data = [
            'title'        => 'Escrow - Studlent',
            'escrows'      => $this->model->getAllEscrows($search, $status),
            'statusCounts' => $this->model->countByStatus(),
            'summary'      => $this->model->getSummary(),
            'search'       => $search,
            'status'       => $status,
        ];

        $this->view('pages/escrows', $data);
    }

    public function detail() {
        $id     = $_GET['id'] ?? null;
        $escrow = $id ? $this->model->getEscrowById($id) : null;

        if (!$escrow) {
            header('Location: ' . BASE_URL . 'escrow');
            exit;
        }

        $this->view('pages/escrow_detail', [
            'title'  => 'Detail Escrow - Studlent',
            'escrow' => $escrow,
        ]);
    }
}