<?php
class Products extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }
        
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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        // $data['image'] = $_FILES['image']['name'];

        if ($this->model('products_model')->addProduct($data) > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Admin added product successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to added product';
        }

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

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }
        
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
