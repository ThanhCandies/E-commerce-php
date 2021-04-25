<?php


namespace App\controllers\admin;

use App\core\middlewares\AdminMiddleware;
use App\core\Request;
use App\core\Response;
use App\models\Category;
use App\models\Image;
use App\models\Product;
use Faker\Factory;


class ProductController extends \App\core\Controller
{

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware([]));
    }

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
     * @param Response $response
     * @return string;
     */
    public function store(Request $request, Response $response): string
    {
        try {
            $input = $request->getBody();
            $file = $request->getFile();

            header("Content-type:application/json");
            /** Set category to null */
            if (isset($input['category_id'])) {
                $input['category_id'] = $input['category_id'] ?: null;
            } else {
                unset($input['category_id']);
            }

            /** Remove image */
            if (isset($input['image_id']) && $input['image_id'] === '0' && empty($file)) {
                $input['image_id'] = null;
            } else {
                /** No remove */
                unset($input['image_id']);
            }


            /** Update */
            if (isset($input['id'])) {
                $product = Product::find($input['id']);
                if (!$product) return json_encode(['success' => false, 'message' => 'product not found']);

                /** Upload file */
                if (!empty($file)) {

                    /** Check if product has file */
                    if (isset($product->image_id)) {
                        $image = Image::find($product->image_id);

                        /** Product don't have file */
                    } else {
                        $image = new Image();
                    }

                    /** Update image attribute */
                    $image->image($request->getFile());
                    /**
                     * Move file
                     *
                     *  -> $id = true (update)      -> merge($input, [])
                     *
                     *  -> $id = number (insert)    -> merge($input,[i])
                     *
                     */

//                    dump($image);
                    if ($image->move()
                        && ($id = (isset($image->id) ? $image->update() : $image->insert([], true)))
                        && $product->update(array_merge($input, $id === true ? [] : [$image->getForeignKey() => $id ? (int)$id : null]))) {
//                        dump($id);
//                        dump([$input, $id === true ? [] : [$image->getForeignKey() => $id ? (int)$id : null]]);
//                        dump(array_merge($input, $id === true ? [] : [$image->getForeignKey() => $id ? (int)$id : null]));
                        return json_encode(['success' => true, 'message' => 'Updated']);
                    };

                    /** Update without file */
                } else {
                    if ($product->update($input)) {
                        return json_encode(['success' => true, 'message' => 'Updated']);
                    }
                }
                return json_encode(['success' => false]);
            } else {
                /** Create */
                $product = Product::create($input);

                header("Content-type:application/json");
                if ($product->validate() && $product->save()) {
                    return json_encode(["success" => $product->isSuccess()]);
                }

                return json_encode(["success" => $product->isSuccess(), "error" => $product->getErrors()]);
            }
        } catch (\Exception $e) {
//            dd($e->getMessage());
            $response->setStatusCode(400);
            return json_encode(["success" => false, "error" => $e]);
        }
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

    public function destroy(Request $request)
    {
        try {
//            dd(file_get_contents('php://input'));

            $input = $request->getBody();
//            dd($input['id']);
            if (!isset($input['id'])) throw new \Exception('Id not found');
            $row = Product::destroy($input['id']);

            if($row===false) return json_encode(['success' => false, 'row' => 0]);
            return json_encode(['success' => true, 'row' => $row]);
        } catch (\Exception $exception) {
            return json_encode(['success' => false, 'message' => $exception->getMessage()]);
        }
    }
}