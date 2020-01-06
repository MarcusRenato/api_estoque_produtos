<?php

namespace Models;

use Core\Model;
use Exception;
use Firebase\JWT\JWT;

class User extends Model
{
    private $key;
    private $idUser;

    public function __construct()
    {
        parent::__construct();

        $this->key = "abc_123_jwt";
    }


    public function create($name, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if (!$this->checkEmail($email)) {
            try {
                $sql = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
                $sql->execute(array($name, $email, $hash));

                $this->idUser = $this->db->lastInsertId();
                return true;
            } catch (\PDOException $e) {
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkCredentials($email, $password)
    {
        $sql = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $sql->execute(array($email));

        if ($sql->rowCount() == 0) {
            return false;
        }

        $data = $sql->fetch(\PDO::FETCH_ASSOC);

        if (!password_verify($password, $data['password'])) {
            return false;
        }

        $this->idUser = $data['id'];
        return true;
    }

    public function createJwt()
    {
        $payload = array(
            "sub" => $this->idUser,
            "iss" => "MarcusRenato"
        );

        $JWT = JWT::encode($payload, $this->key);

        return $JWT;
    }

    public function validateJwt($token)
    {
        if (empty($token)) {
            return false;
        }

        try {
            JWT::decode($token, $this->key, array('HS256'));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function checkEmail($email)
    {
        $sql = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $sql->execute(array($email));

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
