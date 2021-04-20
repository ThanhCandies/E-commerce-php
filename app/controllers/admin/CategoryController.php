<?php


namespace App\controllers\admin;


use App\core\Request;
use App\models\Category;

class CategoryController extends \App\core\Controller
{

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
    }
    public function index(Request $request):string
    {
//        dump($request->getBody());
//        $categories = Category::findAll();
        return $this->render('pages.admin.category');
    }

    public function show(Request $request):string
    {
        $results = $request->getPagination();
        $found= Category::findAll();
        $results['data'] = $found;

        $results["recordsTotal"] = Category::count();
        $results["recordsFiltered"] = Category::count();
        header("Content-type:application/json");
        return json_encode($results);
    }

    public function create(){

    }

    public function store(Request $request):string {
        $category = new Category();
        $category->loadData($request->getBody());

        dd(Category::where('id',3));
        if ($category->validate() && $category->save()) {
            return json_encode(["success" => $category->isSuccess(),]);
        }

        return json_encode(["success" => $category->isSuccess(), "error" => $category->getErrors()]);
    }

    public function edit(){

    }
    public function update(){

    }
    /** remove specified resource */
    public function destroy(){

    }
}