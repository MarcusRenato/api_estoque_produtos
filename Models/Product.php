<?php

namespace Models;

use Core\Model;

class Product extends Model
{
    public function create($name, $description, $quantity, $price)
    {
        $sql = $this->db->prepare(" INSERT INTO
                                        products
                                        (name, description, quantity, price)
                                    VALUES
                                        (?,?,?,?)");
        return $sql->execute(array($name, $description, $quantity, $price));
    }

    public function getAllProducts()
    {
        $data = array();

        $sql = $this->db->query("SELECT * FROM products");

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $data;
    }

    public function getProduct($id)
    {
        $data = array();
        $sql = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $sql->execute(array($id));

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(\PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function update($name, $description, $quantity, $price, $id)
    {
        $sql = $this->db->prepare(" UPDATE
                                        products
                                    SET
                                        name = ?, description = ?,
                                        quantity = ?, price = ?
                                    WHERE
                                        id = ?");
        return $sql->execute(array(
            $name, $description, $quantity, $price, $id
        ));
    }

    public function delete($id)
    {
        $sql = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $sql->execute(array($id));
    }
}
