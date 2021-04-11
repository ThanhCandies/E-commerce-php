<?php

namespace Core\Route;

class Route
{

	private $__routes;

	function __construct()
	{
		$this->__routes = [];
	}

	public static function get(string $url, $action) // Route::get
	{
		self::__request($url, 'GET', $action);
	}
	public static function post(string $url, $action)
	{
		self::__request($url, 'POST', $action);
	}
	private static function __request(string $url, string $method, $action)
	{
		// kiem tra xem URL co chua param khong. VD: post/{id}
		if (preg_match_all('/({([a-zA-Z]+)})/', $url, $params)) {
			$url = preg_replace('/({([a-zA-Z]+)})/', '(.+)', $url);
		}

		// Thay the tat ca cac ki tu / bang ky tu \/ (regex) trong URL.
		$url = str_replace('/', '\/', $url);

		$route = [
			'url' => $url,
			'method' => $method,
			'action' => $action,
			'params' => $params[2]
		];
		array_push($this->__routes, $route);
	}
	public function map(string $url, string $method)
	{
		// code
		foreach ($this->__routes as $route) {
			if ($route['method'] == $method) {
				$reg = '/^' . $route['url'] . '$/';
				if (preg_match($reg, $url, $params)) {
					array_shift($params);
					$this->__call_action_route($route['action'], $params);
					return;
				}
			}
		}
	}
	private function __call_action_route($action, $params)
	{
		// Nếu $action là một callback (một hàm).
		if (is_callable($action)) {
			call_user_func_array($action, $params);
			return;
		}

		// Nếu $action là một phương thức của controller. VD: 'HomeController@index'.
		if (is_string($action)) {
			$action = explode('@', $action);
			$controller_name = 'App\\Controllers\\' . $action[0];
			$controller = new $controller_name();
			call_user_func_array([$controller, $action[1]], $params);

			return;
		}
	}
}
