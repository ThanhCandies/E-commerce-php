<?php


namespace App\controllers\admin;

use App\core\Request;
use App\core\Response;
use App\models\Category;
use App\models\Image;
use App\models\Product;
use Faker\Factory;


class ProductController extends \App\core\Controller
{
    public function index(): string
    {
        $categories = Category::get() ?? [];
        return $this->render('pages.admin.products', ['categories' => $categories]);
    }

    public function getAll(Request $request, Response $response): string
    {
        $results = $request->getPagination();
        $sort_by = $request->getBody()['sort_by'] ?? [];

        $prepare = Product::select('products.*')
            ->outerJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('name', 'regexp', '')
            ->limit($results['length'])
            ->offset($results['length'] * ($results['page'] - 1));

        foreach ($sort_by as $name => $type) {
            $prepare = $prepare->orderBy($name, $type);
        }

        $products = $prepare->get();
        $categoryId = $products->getColumns('category_id');
        $category = Category::whereIn('id', $categoryId)->get();

        $results['data'] = $products->hasOne($category, 'category_id', 'id');;

        $results["recordsTotal"] = Product::count();
        $results["recordsFiltered"] = $prepare->count();
        header("Content-type:application/json");


        return json_encode($results);
    }

    /** create new product and save it
     * @param Request $request
     * @return string;
     */
    public function store(Request $request): string
    {
        $body = $request->getBody();
        $product = new Product();
        $product->loadData($request->getBody());
        header("Content-type:application/json");

        $category = Category::where('id', $body['category']);
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
        /** @var Product $data $input */

        $input = $request->getBody();
        if (!$input['id']) return json_encode(['err' => true, 'message' => 'id required']);

        $data = Product::findOne($input['id']);
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
    }

    public function destroy()
    {

    }

}