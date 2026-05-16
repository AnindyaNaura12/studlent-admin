<?php
require_once BASE_PATH . '/core/Controller.php';

class AuthController extends Controller {
    private $adminModel;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/AdminModel.php';
        $this->adminModel = new AdminModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);

            $admin = $this->adminModel->findByEmail($email);

            if ($admin && password_verify($password, $admin['password'])) {
                if (!$admin['is_active']) {
                    $error = 'Akun kamu tidak aktif.';
                    $this->view('auth/login', ['error' => $error]);
                    return;
                }

                session_start();
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_nama'] = $admin['nama'];
                header('Location: ' . BASE_URL . '/dashboard');
                exit;
            }

            $error = 'Email atau password salah.';
            $this->view('auth/login', ['error' => $error]);
            return;
        }

        $this->view('auth/login');
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
}
