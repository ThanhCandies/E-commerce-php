<?php


namespace App\controllers\admin;


class UsersController extends \App\core\Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
    }

    public function index():string
    {
        return $this->render('pages.admin.userlist');
    }
}