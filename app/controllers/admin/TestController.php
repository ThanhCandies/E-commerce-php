<?php


namespace App\controllers\admin;


use App\core\Request;
use App\core\Query\Builder as DB;
use App\models\Category;
use App\models\Product;
use Doctrine\Inflector\InflectorFactory;

class TestController extends \App\core\Controller
{
    public function index(Request $request)
    {
        $products = Product::select('products.*')
            ->join('categories','products.category_id','=','categories.id')
            ->orderBy('categories.name')
            ->limit(4)->get();
        $categoryId = $products->getColumns('id');
        $category = Category::whereIn('id',$categoryId)->get();
        $results = $products->hasOne($category);

        return(json_encode($results));





//        return json_encode($products);

    }
}