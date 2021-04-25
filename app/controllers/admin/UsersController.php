<?php


namespace App\controllers\admin;


use App\core\Application;
use App\core\Query\Builder;
use App\core\Query\QueryBuilder;
use App\core\Request;
use App\core\Response;
use App\models\Address;
use App\models\Image;
use App\models\Order;
use App\models\Product;
use App\models\User;

class UsersController extends \App\core\Controller
{

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
    }

    public function profile(): string
    {
        return json_encode(User::where('role_id', '!=', 1)->get());
    }

    public function checkout(): string
    {
        # code...
        $carts = session()->get('carts') ?: [];
        if (!empty($carts)) {
            $imageId = array_column($carts,'image_id');
            $productId = array_keys($carts);
            if (!empty($imageId)) {
                $images = Image::whereIn('id', $imageId)->get()->all();
                foreach($images as $image){
                    $pos = array_search($image->id,$imageId);
                    $carts[$productId[$pos]]['image'] = $image->url;
                }
            }
//            dump($carts);
        }
//        dump($_SESSION);
        return $this->render('checkout', compact('carts'));
    }

    public function placeOrder(Request $request, Response $response)
    {
        $carts = session()->get('carts') ?: [];
        $user_id = session()->get('user');
        if (empty($carts)) return false;
        $input = $request->getBody();

        if (isset($input['addressId']) && ((int)$input['addressId'] !== 0)) {
            $addressId = $input['addressId'];
            $address = Address::find($addressId);

            if (!$address) json_encode(['success' => false, 'message' => 'Your id address is wrong']);
        } else if ($input['address'] ?? false) {
            $address = new Address();
            $address->user_id = $user_id;
            $address->address = $input['address'];

            $address->save();
        } else {
            $address = Address::where('user_id', $user_id)->first();
            if (!$address) {
                $response->setStatusCode(400);
                return json_encode(['success' => false, 'message' => 'Please add your address first']);
            }
        }
        $order = new Order();
        $order->address = $address->address;
        $order->user_id = $user_id;
        $order->message = 'Created an order';

        $order->save();

        $oderId = Application::$app->db->pdo->lastInsertId();

        $orderDetails = [];
        foreach ($carts as $key => $product) {
            if (!isset($product['id']) ||
                !isset($product['name']) ||
                !isset($product['count']) ||
                !isset($product['price'])
            ) continue;

            $orderDetails[] = [
                'order_id' => $oderId,
                'product_id' => $product['id'],
                'product_name' => $product['name'],
                'count' => $product['count'],
                'price' => $product['price'],
                'total' => (int)$product['price'] * (int)$product['count']
            ];
        }

        try {
            Builder::table('orderdetails')
                ->attributes('order_id', 'product_id', 'product_name', 'count', 'price', 'total')
                ->insertMany($orderDetails);
        } catch (\Exception $e) {
            $response->setStatusCode(400);
            return json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        session()->set('carts', []);

        return json_encode(['success' => true, 'message' => 'Staff will contact you soon']);
    }

    public function order(): string
    {
        return $this->render('checkout', ['carts' => []]);
    }

    public function addToCart(Request $request, Response $response): bool|string
    {
        header("Content-type:application/json");
        $input = $request->getBody();
        if (!isset($input['id'])) {
            $response->setStatusCode(400);
            return json_encode(['success' => false]);
        }
        $carts = session()->get('carts') ?? [];
        $product = Product::find($input['id']);
        if (!$product) return json_encode(['success' => false]);
        if (isset($carts[$product->id])) {
            $carts[$product->id]['count']++;
        } else {
            $carts[$product->id] = [
                'id' => $product->id,
                'count' => 1,
                'name' => $product->name,
                'price' => $product->price,
                'image_id'=> $product->image_id?:0
            ];
        }
        session()->set('carts', $carts);

        return json_encode(['success' => true, 'carts' => $carts]);
    }

    public function removeItem(Request $request, Response $response): bool|string
    {
        header("Content-type:application/json");

        $input = $request->getBody();
        if (!isset($input['id'])) {
            $response->setStatusCode(400);
            return json_encode(['success' => false]);
        }
        $carts = session()->get('carts') ?? [];

        if (isset($carts[$input['id']])) {
            unset($carts[$input['id']]);
        }
        session()->set('carts', $carts);

        return json_encode(['success' => true, 'carts' => $carts]);
    }
}