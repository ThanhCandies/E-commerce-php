<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\middlewares\AuthMiddleware;
use App\core\Request;
use App\core\Response;
use App\models\Category;
use App\models\Image;
use App\models\Product;

class SiteController extends Controller
{
    /**
     * SiteController constructor.
     */
    public function __construct()
    {
                $this->registerMiddleware(new AuthMiddleware(['checkout','order']));
//        $this->registerMiddleware(new AdminMiddleware([]));
    }

    /**
     * Display a list of the resource
     *
     * @return App\core\Response
     */

    public function home(): string
    {

        $rawCategories = Category::where('published', 1)
//            ->limit()
            ->get();
        $rawProducts = Product::where('published', 1)
            ->orderByDesc('created_at')
            ->limit(10)->get();


        $imageCategories = $rawCategories->getColumns('image_id');
        $imageProducts = $rawProducts->getColumns('image_id');

        $imageId = array_unique(array_merge($imageCategories, $imageProducts));

        $images = Image::whereIn('id', $imageId)->get();

        $categories = $rawCategories->hasOne($images, 'image_id', 'id');
        $products = $rawProducts->hasOne($images, 'image_id', 'id');


//        dump($products);
        return $this->render('index', [
            "categories" => $categories->all(),
            "products" => $rawProducts->all()
        ]);
    }

    public function products(Request $request): string
    {
        $input = $request->getBody();
        $prepareProducts = Product::where('published', 0)//            ->orderByDesc('created_at')
        ;

        foreach ($input as $key => $value) {

            if (strtolower($key) === 'category') {
                $prepareProducts = $prepareProducts->where('category_id', $input['category']);
            }
            if (strtolower($key) === 'sort_by') {
                foreach ($value as $k => $val) {
                    $prepareProducts = $prepareProducts->orderBy($k, strtolower($val) === 'asc' ?'asc': 'desc');
                }
            }
        }

        $total = $prepareProducts->count();

        $rawProducts = $prepareProducts->limit($input['limit'] ?? 12)->get();
        $imageId = $imageProducts = $rawProducts->getColumns('image_id');

        $images = Image::whereIn('id', $imageId)->get();

        $products = $rawProducts->hasOne($images, 'image_id', 'id')->all();

        return $this->render('product', compact('products', 'total'));

    }

    public function category(Request $request)
    {
        $body = $request->getBody();
        return 'Handling data';
    }

    public function edit()
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
