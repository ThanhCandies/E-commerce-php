<?php


namespace App\controllers\admin;

use App\core\Request;
use App\core\Response;
use App\models\Image;

class ImageController extends \App\core\Controller
{
    public function store(Request $request, Response $response): string
    {
//        $basename = '/assets/images/';
        if(!$_FILES["images"]['tmp_name']) return '';
        if ($_FILES["images"]['tmp_name'] && is_array($_FILES["images"]['tmp_name'])) {
            $response->setStatusCode(400);
            header("Content-type:application/json");
            return json_encode(["err" => true, "message" => "Only allow upload single image."]);
        }
        $name = time() . "_" . rand(0, 9999999) . "_" . $_FILES['images']['name'];


        $target = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/';
        $url = $_ENV['DOMAIN'] . '/assets/images/' . $name;
        $target = $target . $name;
        $image = new Image();

        echo $_FILES['images']['tmp_name'];
        $image->loadData([
            "url" => $url,
            "original_name" => $_FILES['images']['name'],
            "type" => $_FILES['images']['type'],
            "size" => $_FILES['images']['size']
        ]);
        // Move file to public/assets/images/...;
        if ($image->validate() && move_uploaded_file($_FILES['images']['tmp_name'], $target) && $image->save()) {
            //Tells you if its all ok
//            echo "The file ". basename( $_FILES['images']['name']). " has been uploaded, and your information has been added to the directory";\
            return $name;

        }
        return false;
    }
}