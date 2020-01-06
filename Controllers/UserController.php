<?php

namespace Controllers;

use Core\Controller;
use Models\User;

class UserController extends Controller
{
    public function login()
    {
        $user = new User();

        $data = $this->getRequestData();
        extract($data);
        $method = $this->getMethod();


        if ($method != "POST") {
            return $this->returnMessage("error", "Método não aceito");
        }

        if (empty($email) || empty($password)) {
            return $this->returnMessage("error", "Campos vazios");
        }

        if (!$user->checkCredentials($email, $password)) {
            return $this->returnMessage("error", "Acesso negado");
        }

        return $this->returnMessage("jwt", $user->createJwt());
    }

    public function create()
    {
        $user = new User();

        $data = $this->getRequestData();
        $method = $this->getMethod();

        if ($method != "POST") {
            return $this->returnMessage("error", "Método não aceito");
        }

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            return $this->returnMessage("error", "Campos vazios");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->returnMessage("error", "Email inválido");
        }

        if (!$user->create($data['name'], $data['email'], $data['password'])) {
            return $this->returnMessage("error", "Email já cadastrado");
        }

        $this->returnMessage("jwt", $user->createJwt());
    }
}
