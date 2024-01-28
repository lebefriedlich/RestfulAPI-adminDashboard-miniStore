<?php
class Login extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login Admin';
        $this->view('templates/header', $data);
        $this->view('login/index');
        $this->view('templates/footer');
    }

    public function login()
    {
        if (isset($_POST['login'])) {
            $loginResult = $this->model('login_model')->login($_POST);

            if ($loginResult > 0) {
                $_SESSION['login'] = true;
                $_SESSION['user'] = $loginResult;
                header('Location: ' . BASEURL);
            } else {
                Flasher::setFlash('Your username or password is incorrect. ', 'please try again', 'danger');
                header('Location: ' . BASEURL . 'home');
                exit;
            }
        }
    }
}
