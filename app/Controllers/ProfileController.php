<?php
require_once BASE_PATH . '/core/Controller.php';

class ProfileController extends Controller {
    private $model;

    public function __construct() {
        session_start();
        if (empty($_SESSION['admin_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        require_once BASE_PATH . '/app/Models/AdminModel.php';
        $this->model = new AdminModel();
    }

    public function index() {
        $admin = $this->model->findById($_SESSION['admin_id']);

        $this->view('pages/profile', [
            'title'   => 'Profile - Studlent',
            'admin'   => $admin,
            'success' => $_SESSION['profile_success'] ?? '',
            'error'   => $_SESSION['profile_error']   ?? '',
        ]);

        unset($_SESSION['profile_success'], $_SESSION['profile_error']);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'profile');
            exit;
        }

        $nama  = trim($_POST['nama']  ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($nama) || empty($email)) {
            $_SESSION['profile_error'] = 'Nama dan email tidak boleh kosong.';
            header('Location: ' . BASE_URL . 'profile');
            exit;
        }

        $data = ['nama' => $nama, 'email' => $email];

        // Handle foto upload ke Supabase Storage
        if (!empty($_FILES['foto']['tmp_name'])) {
            $file     = $_FILES['foto'];
            $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed  = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed)) {
                $_SESSION['profile_error'] = 'Format foto tidak didukung. Gunakan JPG, PNG, atau WebP.';
                header('Location: ' . BASE_URL . 'profile');
                exit;
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                $_SESSION['profile_error'] = 'Ukuran foto maksimal 2MB.';
                header('Location: ' . BASE_URL . 'profile');
                exit;
            }

            // Simpan lokal di public/uploads/
            $uploadDir  = BASE_PATH . '/public/uploads/admins/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $filename   = 'admin_' . $_SESSION['admin_id'] . '.' . $ext;
            move_uploaded_file($file['tmp_name'], $uploadDir . $filename);
            $data['foto'] = BASE_URL . 'uploads/admins/' . $filename;
        }

        $ok = $this->model->updateProfile($_SESSION['admin_id'], $data);

        if ($ok) {
            $_SESSION['admin_nama']    = $nama;
            $_SESSION['profile_success'] = 'Profile berhasil diperbarui!';
        } else {
            $_SESSION['profile_error'] = 'Gagal memperbarui profile. Coba lagi.';
        }

        header('Location: ' . BASE_URL . 'profile');
        exit;
    }

    public function password() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'profile');
            exit;
        }

        $current  = trim($_POST['current_password']  ?? '');
        $new      = trim($_POST['new_password']      ?? '');
        $confirm  = trim($_POST['confirm_password']  ?? '');

        if (empty($current) || empty($new) || empty($confirm)) {
            $_SESSION['profile_error'] = 'Semua field password harus diisi.';
            header('Location: ' . BASE_URL . 'profile');
            exit;
        }

        if ($new !== $confirm) {
            $_SESSION['profile_error'] = 'Password baru dan konfirmasi tidak cocok.';
            header('Location: ' . BASE_URL . 'profile');
            exit;
        }

        if (strlen($new) < 8) {
            $_SESSION['profile_error'] = 'Password baru minimal 8 karakter.';
            header('Location: ' . BASE_URL . 'profile');
            exit;
        }

        $admin = $this->model->findById($_SESSION['admin_id']);
        if (!$admin || !password_verify($current, $admin['password'])) {
            $_SESSION['profile_error'] = 'Password lama tidak sesuai.';
            header('Location: ' . BASE_URL . 'profile');
            exit;
        }

        $ok = $this->model->updateProfile($_SESSION['admin_id'], [
            'password' => password_hash($new, PASSWORD_DEFAULT)
        ]);

        if ($ok) {
            $_SESSION['profile_success'] = 'Password berhasil diubah!';
        } else {
            $_SESSION['profile_error'] = 'Gagal mengubah password. Coba lagi.';
        }

        header('Location: ' . BASE_URL . 'profile');
        exit;
    }
}