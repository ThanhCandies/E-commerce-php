<?php


namespace App\controllers\admin;


use App\core\middlewares\AdminMiddleware;
use App\core\Request;
use App\core\Response;
use App\models\Category;
use App\models\Image;

class CategoryController extends \App\core\Controller
{

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->registerMiddleware(new AdminMiddleware([]));
    }

    public function index(Request $request): string
    {
        return $this->render('pages.admin.category');
    }

    public function show(Request $request): string
    {
        $results = $request->getPagination();
        $sort_by = $request->getBody()['sort_by'] ?? [];

        $prepare = Category::select("categories.*", "(SELECT COUNT(*) FROM products WHERE categories.id = products.category_id) as products")
//            ->select("(SELECT COUNT(*) FROM products WHERE categories.id = products.category_id) as products")
            ->where('name', 'regexp', '')
            ->limit($results['length'])
            ->offset($results['length'] * ($results['page'] - 1));

        foreach ($sort_by as $name => $type) {
            $prepare = $prepare->orderBy($name, $type);
        }
        $categories = $prepare->get();

        $imageId = $categories->getColumns('image_id');
        $images = Image::whereIn('id', $imageId)->get();

        $results['data'] = $categories->hasOne($images, 'image_id', 'id');

        $results["recordsTotal"] = Category::count();
        $results["recordsFiltered"] = $prepare->count();
        header("Content-type:application/json");
        return json_encode($results);
    }

    public function store(Request $request, Response $response): bool|string
    {
        try {
            $input = $request->getBody();
            $file = $request->getFile();
            header("Content-type:application/json");
            /** Set category to null */

            /** Remove image */
            if (isset($input['image_id']) && $input['image_id'] === '0' && empty($file)) {
                $input['image_id'] = null;
            } else {
                /** No remove */
                unset($input['image_id']);
            }


            /** Update */
            if (isset($input['id'])) {
                $category = Category::find($input['id']);

                if (!$category) return json_encode(['success' => false, 'message' => 'Category not found']);

                /** Upload file */
                if (!empty($file)) {

                    /** Check if product has file */
                    if (isset($category->image_id)) {
                        $image = Image::find($category->image_id);

                        /** Category don't have file */
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
                        && $category->update(array_merge($input, $id === true ? [] : [$image->getForeignKey() => $id ? (int)$id : null]))) {
//                        dump($id);
//                        dump([$input, $id === true ? [] : [$image->getForeignKey() => $id ? (int)$id : null]]);

                        return json_encode(['success' => true, 'message' => 'Updated']);
                    };

                    /** Update without file */
                } else {
                    if ($category->update($input)) {
                        return json_encode(['success' => true, 'message' => 'Updated']);
                    }
                }
                return json_encode(['success' => false]);

            } else {
                /** Create */
                $category = Category::create($input);
//                dump($input);

                if ($category->validate() && $category->save()) {
                    return json_encode(["success" => $category->isSuccess()]);
                }

                return json_encode(["success" => $category->isSuccess(), "error" => $category->getErrors()]);
            }
        } catch (\Exception $e) {
//            dd($e->getMessage());
            $response->setStatusCode(400);
            return json_encode(["success" => false, "error" => $e]);
        }
    }

    /** remove specified resource
     * @param Request $request
     * @return bool|string
     */
    public function destroy(Request $request): bool|string
    {
        try {
            $input = $request->getBody();

            if (!isset($input['id'])) throw new \Exception('Id not found');

            $row = Category::destroy($input['id']);

            if($row===false) return json_encode(['success' => false, 'row' => 0]);
            return json_encode(['success' => true, 'row' => $row]);
        } catch (\Exception $exception) {
            return json_encode(['success' => false, 'message' => $exception->getMessage()]);
        }
    }
}