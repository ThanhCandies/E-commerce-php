<?php


namespace App\models;


use App\core\Model;

class Products extends Model
{

    public static function tableName(): string
    {
        return 'products';
    }

    public function attributes(): array
    {
        return [];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [
            'name'=>[self::RULE_REQUIRED,[self::RULE_UNIQUE,'class'=>self::class]]
        ];
    }
}