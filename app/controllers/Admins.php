<?php
class Admins extends Controller
{
    public $response = [];
    public function index()
    {
        $data['judul'] = 'Menu Admin - Admins';
        $data['admins'] = $this->model('admins_model')->loadAdmin();
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function addAdmin()
    {
        $emails = $this->model('admins_model')->checkEmailAdmin($_POST['email']);
        if ($emails) {
            $response['status'] = 'error';
            $response['message'] = 'Email is already registered';
            $response['http_code'] = 400;
        } else {
            if ($this->model('admins_model')->addAdmin($_POST) > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Admin added successfully';
                $response['http_code'] = 201;
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to add admin';
                $response['http_code'] = 500;
            }
        }

        http_response_code($response['http_code']);
        unset($response['http_code']);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function edit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'PUT' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        parse_str(file_get_contents("php://input"), $_PUT);

        if ($_PUT['pass'] === $_PUT['passOld']) {
            unset($_PUT['pass']);
        }

        if ($this->model('admins_model')->edit($_PUT) > 0) {
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Admin edited successfully'
            ]);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to edited admin'
            ]);
        }
    }

    public function delete($id_user)
    {
        if ($this->model('admins_model')->delete($id_user) > 0) {
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Admin deleted successfully'
            ]);
        } else {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to deleted admin'
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
