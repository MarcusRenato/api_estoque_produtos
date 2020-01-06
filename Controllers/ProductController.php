<?php

namespace Controllers;

use Core\Controller;
use Core\Validade;
use Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $jwt = "";
        extract($data = $this->getRequestData());

        if (!Validade::accessValidate($jwt)) {
            http_response_code(401);
            return $this->returnMessage("error", "Acesso Negado");
        }
    }

    public function create()
    {
        $product = new Product();
        $method = $this->getMethod();
        extract($data = $this->getRequestData());

        if ($method != "POST") {
            http_response_code(405);
            return $this->returnMessage("error", "Método não permitido");
        }

        if (empty($name) || empty($description) || empty($quantity) || empty($price)) {
            return $this->returnMessage("error", "Não pode haver campos vazios");
        }

        if (!$product->create($name, $description, $quantity, $price)) {
            return $this->returnMessage("error", "Produto não adicionado");
        }

        return $this->returnMessage("success", "Produto adicionado com sucesso!");
    }

    public function getAllProducts()
    {
        $product = new Product();
        return $this->returnJson($product->getAllProducts());
    }

    public function view($id)
    {
        $product = new Product();
        $method = $this->getMethod();
        extract($data = $this->getRequestData());

        switch ($method) {
            case "GET":
                return $this->returnJson($product->getProduct($id));
                break;

            case "PUT":
                if (empty($name) || empty($description) || empty($quantity) || empty($price)) {
                    return $this->returnMessage("error", "Não pode haver campos vazios");
                }

                if (!$product->update($name, $description, $quantity, $price, $id)) {
                    return $this->returnMessage("error", "Produto não adicionado");
                }

                return $this->returnMessage("success", "Produto editado com sucesso!");
                break;

            case "DELETE":
                if (!$product->delete($id)) {
                    return $this->returnMessage("error", "Produto não excluído");
                }

                return $this->returnMessage("success", "Produto excluído com sucesso!");
                break;

            default:
                http_response_code(405);
                return $this->returnMessage("error", "Método não aceito");
                break;
        }
    }
}
