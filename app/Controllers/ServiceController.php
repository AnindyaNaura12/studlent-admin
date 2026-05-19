<?php
require_once BASE_PATH . '/core/Controller.php';

class ServiceController extends Controller {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/Models/ServiceModel.php';
        $this->model = new ServiceModel();
    }

    public function index() {
        $search   = trim($_GET['search']   ?? '');
        $status   = trim($_GET['status']   ?? '');
        $category = trim($_GET['category'] ?? '');

        $data = [
            'title'        => 'Services - Studlent',
            'services'     => $this->model->getAllServices($search, $status, $category),
            'categories'   => $this->model->getAllCategories(),
            'statusCounts' => $this->model->countByStatus(),
            'search'       => $search,
            'status'       => $status,
            'category'     => $category,
        ];

        $this->view('pages/services', $data);
    }

    public function detail() {
        $id      = $_GET['id'] ?? null;
        $service = $id ? $this->model->getServiceById($id) : null;

        if (!$service) {
            header('Location: ' . BASE_URL . 'service');
            exit;
        }

        $this->view('pages/service_detail', [
            'title'    => 'Detail Service - Studlent',
            'service'  => $service,
            'packages' => $this->model->getPackagesByService($id),
            'images'   => $this->model->getImagesByService($id),
        ]);
    }

    public function updatestatus() {
        $id     = $_POST['id']     ?? null;
        $status = $_POST['status'] ?? null;

        $allowed = ['active', 'inactive', 'pending', 'rejected'];
       // validasi
        if (!$id || !in_array($status, $allowed)) {

            header('Location: ' . BASE_URL . 'service');

            exit;
        }

        // update status
        $updated = $this->model->updateStatus(
            $id,
            $status
        );


        // dipakai alert sukses/gagal
        if (!$updated) {

            die('Gagal update status service');
        }

        // Redirect balik ke detail kalau ada, atau ke list
        $from = $_POST['from'] ?? '';
        if ($from) {
            header('Location: ' . BASE_URL . 'service/detail?id=' . urlencode($from));
        } else {
            header('Location: ' . BASE_URL . 'service');
        }
        exit;
    }
}