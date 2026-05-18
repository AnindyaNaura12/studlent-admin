<?php
require_once BASE_PATH . '/core/Controller.php';

class WithdrawalController extends Controller {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/WithdrawalModel.php';
        $this->model = new WithdrawalModel();
    }

    public function index() {
        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $data = [
            'title'        => 'Withdrawals - Studlent',
            'withdrawals'  => $this->model->getAllWithdrawals($search, $status),
            'statusCounts' => $this->model->countByStatus(),
            'totalApproved'=> $this->model->getTotalAmount('approved'),
            'totalPending' => $this->model->getTotalAmount('pending'),
            'search'       => $search,
            'status'       => $status,
        ];

        $this->view('pages/withdrawals', $data);
    }

    public function detail() {
        $id         = $_GET['id'] ?? null;
        $withdrawal = $id ? $this->model->getWithdrawalById($id) : null;

        if (!$withdrawal) {
            header('Location: ' . BASE_URL . 'withdrawal');
            exit;
        }

        $this->view('pages/withdrawal_detail', [
            'title'      => 'Detail Withdrawal - Studlent',
            'withdrawal' => $withdrawal,
        ]);
    }

    public function updatestatus() {
        $id     = $_POST['id']     ?? null;
        $status = $_POST['status'] ?? null;
        $from   = $_POST['from']   ?? '';

        $allowed = ['pending', 'approved', 'rejected'];
        if ($id && in_array($status, $allowed)) {
            $this->model->updateStatus($id, $status);
        }

        if ($from) {
            header('Location: ' . BASE_URL . 'withdrawal/detail?id=' . urlencode($from));
        } else {
            header('Location: ' . BASE_URL . 'withdrawal');
        }
        exit;
    }
}