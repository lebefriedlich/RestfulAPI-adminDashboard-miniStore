<?php
class Dashboard extends Controller
{
    public function index()
    {

        $data['judul'] = 'Menu Admin';
        $data['sumUsers'] = $this->model('dashboard_model')->sumUsers();
        $data['sumProducts'] = $this->model('dashboard_model')->sumProducts();
        $data['sumSoldOut'] = $this->model('dashboard_model')->sumSoldOut();
        $data['carts'] = $this->model('dashboard_model')->loadCart();

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function logout()
    {
        session_destroy();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'logout']);
        exit();
    }
}
