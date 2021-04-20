<?php


namespace App\controllers\admin;


use App\core\Request;
use App\core\Query\Builder as DB;
use App\models\Category;
use App\models\Image;
use App\models\Product;
use Doctrine\Inflector\InflectorFactory;

class TestController extends \App\core\Controller
{
    public function index(Request $request)
    {
        try {
            $input = ['id' => 5, 'name' => 'Testing2','set'=>'asd'];


            $products = Product::create($input);
//            dd($products->validate(),$products);
            if (!$products) {
                return (json_encode(['message' => 'Product not found']));
            }
            $arr = ['test' => ''];
            $image = Image::image($request->getFile());

            dd($image->upsert());
//        dump($products->all()[1]->categories);
            return (json_encode($products));
        } catch (\Exception $e) {
            return json_encode($e);
        }
    }
}