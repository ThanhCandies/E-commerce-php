<?php


namespace App\controllers\admin;


class CategoryController extends \App\core\Controller
{

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
    }
    public function index():string
    {
        return $this->render('pages.admin.category');
    }

    public function create(){

    }

    public function store() {

    }

    public function show() {

    }

    public function edit(){

    }
    public function update(){

    }
    /** remove specified resource */
    public function destroy(){

    }
}