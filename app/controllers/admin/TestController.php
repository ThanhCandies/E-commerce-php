<?php


namespace App\controllers\admin;


use App\core\Query\Builder;
use App\core\Request;
use App\core\Query\Builder as DB;
use App\models\Category;
use App\models\Image;
use App\models\Product;
use App\models\User;
use Doctrine\Inflector\InflectorFactory;

class TestController extends \App\core\Controller
{
    public function index(Request $request)
    {
        $orderDetails=[];
        $orderDetails[]=[
            'order_id'=>1,
            'product_id'=>5,
            'product_name'=>'Testing2',
            'count'=>1,
            'price'=>1000,
            'total'=>10000
        ];
        Builder::table('orderdetails')
            ->attributes('order_id', 'product_id', 'product_name', 'count', 'price', 'total')
            ->insertMany($orderDetails);
        return json_encode(true);
    }
    public function put(Request $request){
        header('Content-Type:application/json');
        parse_str(file_get_contents('php://input'),$body);

        echo json_encode(["json"=>json_decode(file_get_contents('php://input')),
            'php_input' =>file_get_contents('php://input'),
            'parse'=>$body,
            'file'=>$_FILES,
            'server'=>$_SERVER

        ]);

    }
    public function post(Request $request){
        parse_str(file_get_contents('php://input'),$body);
        header('Content-Type:application/json');
        echo json_encode(["Request"=>$_POST,
            'json'=>json_decode(file_get_contents('php://input')),
            "php_input"=>file_get_contents('php://input'),
            'parse'=>$body,
            'file'=>$_FILES,
            'server'=>$_SERVER

        ]);


    }
    public function delete(Request $request){
        header('Content-Type:application/json');
        parse_str(file_get_contents('php://input'),$body);
//        dd(["Json"=>json_decode(file_get_contents('php://input')),
//            'php_input'=>file_get_contents('php://input'),
//            'parse'=>$body,
//            'file'=>$_FILES,
//            'server'=>$_SERVER['CONTENT_TYPE']
//
//
//        ]);
        echo json_encode(["Json"=>json_decode(file_get_contents('php://input')),
            'php_input'=>file_get_contents('php://input'),
            'parse'=>$body,
            'file'=>$_FILES,
            'server'=>$_SERVER


        ]);

    }
}