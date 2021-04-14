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
	public function index():string
	{
		return $this->render('index');
	}

	public function create():string
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
