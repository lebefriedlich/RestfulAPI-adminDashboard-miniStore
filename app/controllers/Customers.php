<?php
class Customers extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $data['judul'] = 'Menu Admin - Customers';
        $data['users'] = $this->model('customers_model')->loadUser();
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        if ($data['pass'] !== $data['confirmPass']) {
            $response['status'] = 'error';
            $response['message'] = 'Password not match';
            header('Content-type: application/json');
            echo json_encode($response);
            exit;
        }

        $emails = $this->model('customers_model')->checkEmailUser($data['email']);
        if ($emails) {
            $response['status'] = 'error';
            $response['message'] = 'Email is already registered';
        }

        if ($this->model('customers_model')->addUser($data) > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Admin added user successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to added user';
            $response['http_code'] = 500;
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function edit(string $id)
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        parse_str(file_get_contents("php://input"), $_PUT);

        if ($_PUT['pass'] === $_PUT['passOld']) {
            unset($_PUT['pass']);
        }

        $_PUT['id_user'] = $id;

        if ($this->model('customers_model')->edit($_PUT) > 0) {
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Admin edited user successfully'
            ]);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to edited user'
            ]);
        }
    }

    public function delete($id_user)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        if ($this->model('customers_model')->delete($id_user) > 0) {
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Admin deleted user successfully'
            ]);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to deleted user'
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
