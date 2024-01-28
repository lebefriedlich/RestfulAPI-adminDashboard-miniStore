<?php
class Products extends Controller
{
    public function index()
    {
        $data['judul'] = 'Menu Admin - Products';
        $data['products'] = $this->model('products_model')->loadProducts();
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function addProduct()
    {
        $_POST['image'] = $_FILES['image']['name'];

        if ($this->model('products_model')->addProduct($_POST) > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Admin added product successfully';
            $response['http_code'] = 201;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to added product';
            $response['http_code'] = 500;
        }

        http_response_code($response['http_code']);
        unset($response['http_code']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function editProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        parse_str(file_get_contents("php://input"), $_PUT);

        if (empty($_FILES['image']['name'])) {
            unset($_POST['image']);
        }

        if ($this->model('products_model')->editProduct($_POST) > 0) {
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Admin edited product successfully'
            ]);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to edited product'
            ]);
        }
    }

    public function deleteProduct($id_product)
    {
        if ($this->model('products_model')->deleteProduct($id_product) > 0) {
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Admin deleted product successfully'
            ]);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to deleted product'
            ]);
        }
    }

    public function logout()
    {
        session_destroy();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'logout']);
        exit();
    }
}