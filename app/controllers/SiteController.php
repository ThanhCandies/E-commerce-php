<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;

class SiteController extends Controller
{
	/**
	 * Display a list of the resource
	 * 
	 * @return App\core\Response
	 */
	public function index()
	{
		return $this->renderSingle('index');
	}

	public function create()
	{
		$params = ['name' => 'hello'];
		return $this->render('contact', $params);
	}
	public function store(Request $request)
	{
		$body = $request->getBody();
		return 'Handling data';
	}

	public function show()
	{
		# code...
	}
	public function edit()
	{
		//
	}
	public function update()
	{
		//
	}
	public function destroy()
	{
		//
	}
	public function contact()
	{
	
	}

}
