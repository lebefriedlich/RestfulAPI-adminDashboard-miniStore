<?php

class customers_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function loadUser()
    {
        $query = "SELECT * FROM users WHERE id_role = '2'";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function checkEmailUser($email)
    {
        $query = "SELECT email FROM users WHERE email = :email AND id_role = '2'";
        $this->db->query($query);
        $this->db->bind('email', $email);
        return $this->db->single();
    }

    public function addUser($data)
    {
        $query = "INSERT INTO users
                        VALUES
                      ('', :name_user , :email, :pass, '2')";
        $this->db->query($query);
        $this->db->bind("name_user", $data['name_user']);
        $this->db->bind("email", $data['email']);
        $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
        $this->db->bind("pass", $data['pass']);
        $this->db->execute();
        return $this->db->Rowcount();
    }

    public function edit($data)
    {
        $query = "UPDATE users
              SET name_user = :name_user, email = :email";

        if (isset($data['pass']) && !empty($data['pass'])) {
            $query .= ", pass = :pass";
            $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
        }

        $query .= " WHERE id_user = :id_user";

        $this->db->query($query);
        $this->db->bind("name_user", $data['name_user']);
        $this->db->bind("email", $data['email']);

        if (isset($data['pass']) && !empty($data['pass'])) {
            $this->db->bind("pass", $data['pass']);
        }

        $this->db->bind('id_user', $data['id_user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id_user)
    {
        $query = "DELETE FROM users WHERE id_user = :id_user";
        $this->db->query($query);
        $this->db->bind("id_user", $id_user);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
