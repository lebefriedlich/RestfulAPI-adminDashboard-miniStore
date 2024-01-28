<?php

class dashboard_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function sumUsers(){
        $query = "SELECT COUNT(*) AS '0' FROM users";
        $this->db->query($query);
        return $this->db->single();
    }

    public function sumProducts(){
        $query = "SELECT COUNT(*) AS '0' FROM products";
        $this->db->query($query);
        return $this->db->single();
    }

    public function sumSoldOut(){
        $query = "SELECT COUNT(*) AS '0' FROM checkout_items";
        $this->db->query($query);
        return $this->db->single();
    }


    public function loadCart()
    {
        $query = "SELECT checkouts.name, checkouts.phone, checkouts.address, checkout_items.price, checkout_items.qty,
                    products.name_product, checkouts.checkout_date, users.email
                    FROM checkout_items 
                    JOIN checkouts
                    ON checkout_items.id_checkout = checkouts.id_checkout 
                    JOIN users
                    ON checkouts.id_user = users.id_user 
                    JOIN products
                    ON checkout_items.id_product = products.id_product";
        $this->db->query($query);
        return $this->db->resultSet();
    }
}
