<?php

class login_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($data)
    {
        $query = "SELECT * FROM users WHERE email = :email AND id_role = '1'";
        $this->db->query($query);
        $this->db->bind('email', $data['email']);
        $result = $this->db->single();

        if ($result) {
            $hashedPassword = $result['pass'];
            $enteredPassword = $data['password'];

            if (password_verify($enteredPassword, $hashedPassword)) {
                return $result;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
