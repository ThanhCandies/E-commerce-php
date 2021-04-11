<?php

namespace App\core;

use App\core\Application;

class Controller
{
	public string $layout = "main";

	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	protected function render($view, $params = [])
	{
		return Application::$app->route->renderView($view, $params);
	}
	
	protected function renderSingle($view, $params = [])
	{
		return Application::$app->route->renderViewOnly($view, $params);
	}
	protected function authenticate(){
	}
}
