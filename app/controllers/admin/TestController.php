<?php


namespace App\controllers\admin;


use App\core\Request;

class TestController extends \App\core\Controller
{
    public function index(Request $request){
//        dd($request->getBody());
        var_dump($request->getBody());
        exit();
    }
}