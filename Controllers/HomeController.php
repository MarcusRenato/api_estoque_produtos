<?php

namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use Firebase\JWT\JWT;
use Models\User;

class HomeController extends Controller
{

	public function index()
	{
		$user = new User();

		$token = $user->createJwt(5);

		$tkb = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjUsImlzcyI6Ik1hcmN1c1JlbmF0byJ9.q4llnLeFef0_jICP4yJlF3Jrotbo8-GYSwTr8isAA_o";

		if ($user->validateJwt($tkb)) {
			$data = $user->validateJwt($tkb);
		} else {
			$data = $user->validateJwt($tkb);
		}
		$data['token'] = $token;
		return $this->returnJson($data);
	}

	public function teste()
	{
		echo $this->getMethod();
	}
}
