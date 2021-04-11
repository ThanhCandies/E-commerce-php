<?php

namespace App\core;

use App\controllers\SiteController;

class Router
{
	protected array $routes = [];
	protected Request $request;
	protected Response $response;

	function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function get($path, $cb)
	{
		$this->routes['GET'][$path] = $cb;
	}
	public function post($path, $cb)
	{
		$this->routes['POST'][$path] = $cb;
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->getMethod();

		$cb = $this->routes[$method][$path] ?? false;
		if (!$cb) {
			$this->response->setStatusCode(404);
			return $this->renderViewOnly("_404",[]);
		};

		if (is_string($cb)) {
			return $this->renderView($cb);
		}
		if (is_array($cb)) {
			Application::$app->controller = new $cb[0]();
			$cb[0] = Application::$app->controller;
		}
		return call_user_func($cb, $this->request,$this->response);
	}

	public function renderView($view, $params = [])
	{
		$layoutContent = $this->layoutContent();
		$viewContent = $this->renderViewOnly($view, $params);
		return str_replace('{{content}}', $viewContent, $layoutContent);
	}

	protected function layoutContent()
	{
		$layout = Application::$app->controller->layout;
		ob_start();
		include_once Application::$ROOT_DIR . "/app/views/layouts/$layout.php";
		return ob_get_clean();
	}

	/**
	 * Render only one view
	 * 
	 * @param string $view
	 * @param string[]	@params
	 */

	public function renderViewOnly($view, $params)
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}

		ob_start();
		include_once Application::$ROOT_DIR . "/app/views/$view.php";
		return ob_get_clean();
	}
}
