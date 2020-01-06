<?php
namespace Core;
use Models\User;

class Validade
{
    public static function accessValidate($jwt)
    {
        $user = new User();

        if ($user->validateJwt($jwt)) {
            return true;
        }
        
        return false;
    }
}