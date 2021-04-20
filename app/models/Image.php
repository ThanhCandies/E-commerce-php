<?php


namespace App\models;


use JetBrains\PhpStorm\ArrayShape;

class Image extends \App\core\DbModel
{
    public string $url = '';
    public string $original_name = '';
    public string $type = '';
    public int|null $product_id = null;
    public int $size = 0;
    private string $target = "";

    public function loadImage($image, int|null $product_id = null)
    {
        $name = time() . "_" . rand(0, 9999999) . "_" . $image['name'];
        $this->url = $_ENV['DOMAIN'] . '/assets/images/' . $name;
        $this->original_name = $image['name'];
        $this->product_id = $product_id;
        $this->type = $image['type'];
        $this->size = $image['size'];
        $this->target= $_SERVER['DOCUMENT_ROOT'] . '/assets/images/'.$name;
    }
    public function move(): bool
    {
        return move_uploaded_file($_FILES['images']['tmp_name'], $this->target);
    }

    public static function attributes(): array
    {
        return ['url', 'original_name', 'type', 'size'];
    }

    public static function foreignKey():array
    {
        return [Products::class=>'product_id'];
    }

    public function rules(): array
    {
        return [
            'url' => [self::RULE_REQUIRED],
            'type' => [[self::RULE_TYPE, "accept" => "image/png|image/jpg|image/jpeg|image/webp"]]
        ];
    }
}