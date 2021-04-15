<?php


namespace App\controllers\admin;

use App\core\Request;
use App\core\Response;
use App\models\Image;
use App\models\Products;
use Faker\Factory;


class ProductController extends \App\core\Controller
{
    public function index(): string
    {
        return $this->render('pages.admin.products');
    }

    public function getAll(Request $request, Response $response): string
    {
        $recordsTotal = 15;
        $recordsFiltered = 8;

        $length = (int)$request->getBody()['length'];
        $draw = (int)$request->getBody()['draw'];
        $start = (int)$request->getBody()['start'];
        $faker = Factory::create();
        $results = [];
        $max = $recordsFiltered - $start > $length ? $length : $recordsFiltered - $length;
        for ($i = 0; $i < $max; $i++) {
            $results[] = [
                "id" => $faker->uuid,
                "name" => $faker->name,
                "category" => $faker->name,
                "status" => $faker->colorName,
                "published" => $faker->boolean,
                "price" => $faker->numberBetween([100, 200])
            ];
        }
        header("Content-type:application/json");
        return json_encode([
            "data" => $results,
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            $request->getBody()
        ]);
    }

    /** create new product and save it
     * @param Request $request
     * @return string;
     */
    public function store(Request $request): string
    {
        $product = new Products();
        $product->loadData($request->getBody());
        header("Content-type:application/json");
//        dd($product,$request->getBody());
        if ($product->validate() && $product->save()) {
            return json_encode(["success" => $product->isSuccess(),]);
        }
//        dd($product,$request->getBody());
        return json_encode(["success" => true, "error" => $product->getErrors()]);
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