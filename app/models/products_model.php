<?php

class products_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function loadProducts()
    {
        $query = "SELECT * FROM products";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function addProduct($data)
    {
        $query = "INSERT INTO products VALUES
                    ('', :name_product, :descr, :img, :price, :qty, :category, :brand)";
        $this->db->query($query);
        $this->db->bind("name_product", $data['name_product']);
        $this->db->bind("descr", $data['description']);
        $this->db->bind("img", $data['image']);
        $this->db->bind("price", $data['price']);
        $this->db->bind("qty", $data['qty']);
        $this->db->bind("category", $data['category']);
        $this->db->bind("brand", $data['brand']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function editProduct($data)
    {
        $query = "UPDATE products
                    SET name_product = :name_product, description = :descr";

        if (isset($data['image']) && !empty($data['image'])) {
            $query .= ", 'image' = :img";
        }

        $query .= ", price = :price, qty = :qty, category = :category, brand = :brand
                    WHERE id_product = :id_product";

        $this->db->query($query);
        $this->db->bind("name_product", $data['name_product']);
        $this->db->bind("descr", $data['description']);

        if (isset($data['image']) && !empty($data['image'])) {
            $this->db->bind("img", $data['image']);
        }

        $this->db->bind("price", $data['price']);
        $this->db->bind("qty", $data['qty']);
        $this->db->bind("category", $data['category']);
        $this->db->bind("brand", $data['brand']);
        $this->db->bind("id_product", $data['id_product']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteProduct($id_product)
    {
        $query = "DELETE FROM products WHERE id_product = :id_product";
        $this->db->query($query);
        $this->db->bind("id_product", $id_product);
        $this->db->execute();

        return $this->db->rowCount();
    }
}
