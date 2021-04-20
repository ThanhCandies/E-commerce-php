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
        $categories = Category::get()->all() ?? [];
//        dump($categories[0]);
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
        $imageId = $products->getColumns('image_id');
        $category = Category::whereIn('id', $categoryId)->get();
        $images = Image::whereIn('id', $imageId)->get();

        $results['data'] = $products
            ->hasOne($category, 'category_id', 'id')
            ->hasOne($images, 'image_id', 'id');

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
        $input = $request->getBody();

        $product = Product::create($input);
        header("Content-type:application/json");

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
        /** @var Product $product */

        $input = $request->getBody();
        if (!$input['id']) return json_encode(['err' => true, 'message' => 'id required']);

        $product = Product::find($input['id']);
        if (!$product) return json_encode(['err' => true, 'message' => 'product not found']);

        $file = $request->getFile();
        if ($file) {
            Image::find($product->image_id)->delete();
        }
        $image = Image::image($request->getFile());

        header("Content-type:application/json");

        if ($image->validate()
            && $image->move()
            && ($id = $image->upsert())
            && $product->update(array_merge($input, [$image->getForeignKey() => is_int($id) ? $id : null]))) {
            return json_encode(['success' => true]);
        };

        return json_encode(['err' => true]);
    }

    public function destroy()
    {

    }

}