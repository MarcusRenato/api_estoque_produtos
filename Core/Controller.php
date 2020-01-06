<?php

namespace Core;

class Controller
{
	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getRequestData()
	{
		switch ($this->getMethod()) {
			case 'GET':
				return $_GET;
				break;

			case 'PUT':
			case 'DELETE':
				parse_str(file_get_contents('php://input'), $data);

				if (empty($data)) {
					$data = $_REQUEST;
				}
				return (array) $data;
				break;

			case 'POST':
				$data = json_decode(file_get_contents('php://input'));

				if (is_null($data)) {
					$data = (empty($_POST)) ? $_REQUEST : $_POST;
				}

				return (array) $data;
				break;
		}
	}

	public function returnMessage($name, $message)
	{
		$array[$name] = $message;
		return $this->returnJson($array);
	}

	public function returnJson($array)
	{
		header("Content-Type: application/json");
		echo json_encode($array);
		exit;
	}
}
