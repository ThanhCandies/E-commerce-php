<?php


namespace App\models;


class Image extends \App\core\DbModel
{

    public static function tableName(): string
    {
        return 'images';
    }

    public function attributes(): array
    {
        return ['url','original_name','title','type','size'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'url'=>[self::RULE_REQUIRED]
        ];
    }
}