<?php
class Login extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $data['judul'] = 'Login Admin';
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function aunthenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);
        
        $loginResult = $this->model('login_model')->login($data);

        if ($loginResult) {
            http_response_code(201);
            $response['status'] = 'success';
            $response['message'] = 'Success to login';
            $response['data'] = $loginResult;
        } else {
            http_response_code(500);
            $response['status'] = 'error';
            $response['message'] = 'email or password wrong';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
