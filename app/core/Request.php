<?php

namespace App\core;

class Request
{

	// public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
  //   {
  //       // $this->initialize($query, $request, $attributes, $cookies, $files, $server, $content);
	// 			// dd($query, $request, $attributes, $cookies, $files, $server, $content);
  //   }

	public function getPath()
	{
		$path = $_SERVER['REQUEST_URI'] ?? '\/';
		$position = stripos($path, '?');
		if (!$position) {
			return $path;
		};
		return $path = substr($path, 0, $position);
	}

	public function getMethod()
	{
		return strtoupper($_SERVER['REQUEST_METHOD']);
	}

	public function getBody()
	{
		$body = [];
		if($_SERVER["CONTENT_TYPE"]==='application/json; charset=UTF-8'&&$this->getMethod() === 'POST'){
			$_POST=json_decode(file_get_contents('php://input'));
		}

		// need handle application/json latter
		// dump($_POST);
		if ($this->getMethod() === 'GET') {
			foreach ($_GET as $key => $value) {
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		if ($this->getMethod() === 'POST') {
			foreach ($_POST as $key => $value) {
				// $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
				$body[$key] = filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		return $body;
	}

	public function isGet()
	{
		return $this->getMethod()==="GET";
	}
	public function isPost()
	{
		return $this->getMethod()==="POST";
	}

}
