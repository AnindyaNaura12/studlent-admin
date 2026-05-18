<?php
require_once BASE_PATH . '/core/Controller.php';

class UserController extends Controller {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/UserModel.php';
        $this->model = new UserModel();
    }

    public function index() {
        $search = trim($_GET['search'] ?? '');
        $role   = trim($_GET['role']   ?? '');
        $status = trim($_GET['status'] ?? '');

        $data = [
            'title'      => 'Users - Studlent',
            'users'      => $this->model->getAllUsers($search, $role, $status),
            'roleCounts' => $this->model->countByRole(),
            'search'     => $search,
            'role'       => $role,
            'status'     => $status,
        ];

        $this->view('pages/users', $data);
    }

    public function detail() {
        $id   = $_GET['id'] ?? null;
        $user = $id ? $this->model->getUserById($id) : null;

        if (!$user) {
            header('Location: ' . BASE_URL . '/user');
            exit;
        }

        $this->view('pages/user_detail', [
            'title' => 'Detail User - Studlent',
            'user'  => $user,
        ]);
    }

    public function toggle() {
        $id     = $_POST['id']     ?? null;
        $status = $_POST['status'] ?? '0';

        if ($id) {
            $this->model->toggleActive($id, (bool)$status);
        }

        header('Location: ' . BASE_URL . '/user');
        exit;
    }
}