<?php


namespace App\models;


use JetBrains\PhpStorm\ArrayShape;

class Image extends \App\core\DbModel
{
    public array $fillable=[
       'id','name','url','size','type'
    ];
    public function move(): bool
    {
        return move_uploaded_file($_FILES['images']['tmp_name'], $this->getAttribute('target'));
    }

    public static function attributes(): array
    {
        return ['url', 'original_name', 'type', 'size'];
    }

    public function rules(): array
    {
        return [
            'url' => [self::RULE_REQUIRED],
            'type' => [[self::RULE_TYPE, "accept" => "image/png|image/jpg|image/jpeg|image/webp"]]
        ];
    }
}