<?php


namespace App\controllers\admin;

use App\core\Request;
use App\core\Response;
use App\models\Category;
use App\models\Image;
use App\models\Products;
use Faker\Factory;


class ProductController extends \App\core\Controller
{
    public function index(): string
    {
        $categories = Category::findAll()??[];
        return $this->render('pages.admin.products',['categories'=>$categories]);
    }

    public function getAll(Request $request, Response $response): string
    {
        $results = $request->getPagination();
        $found = Products::findAll(['category']);

        $results['data'] = $found;
//        $results['stmt'] = $found['stmt'];

        $results["recordsTotal"] = Products::count();
        $results["recordsFiltered"] = Products::count();
        header("Content-type:application/json");
//        dd($results);
        return json_encode($results);
    }

    /** create new product and save it
     * @param Request $request
     * @return string;
     */
    public function store(Request $request): string
    {
        $body = $request->getBody();
        $product = new Products();
        $product->loadData($request->getBody());
        header("Content-type:application/json");

        $category = Category::where('id',$body['category']);
        if (!$category) $body['category'] = 0;

        if ($product->validate() && $product->save()) {
            return json_encode(["success" => $product->isSuccess(),]);
        }

        return json_encode(["success" => $product->isSuccess(), "error" => $product->getErrors()]);
    }

    /** update new product
     * @param Request $request
     * @return string;
     */
    public function update(Request $request): string
    {
        /** @var Products $data $input */

        $input = $request->getBody();
        if (!$input['id']) return json_encode(['err' => true, 'message' => 'id required']);

        $data = Products::findOne($input['id']);
        if (!$data) return json_encode(['err' => true, 'message' => 'product not found']);

        $image = new Image();
        $image->loadImage($request->getFile(), (int)$data->id);

        header("Content-type:application/json");
        if ($data->validate()
            && $image->validate()
            && $image->move()
            && $data->update()
            && $image->save()) {
            return json_encode(['success' => true]);
        };

        return json_encode(['err' => true]);
//        dd($request->getFile(), $request->getBody());
    }

    public function destroy()
    {

    }

}