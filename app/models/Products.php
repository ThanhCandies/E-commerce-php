<?php


namespace App\models;


use App\core\DbModel;
use JetBrains\PhpStorm\ArrayShape;

class Products extends DbModel
{
    public int|null $id = 0;
    public string $name = '';
    public bool|int|null $published = false;
    public int $price = 0;
    public int|object|null $category = 0;
    public int|null|object $image = 0;

    public static function tableName(): string
    {
        return 'products';
    }

    public static function attributes(): array
    {
        return ['id','name', 'published', 'price','category'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
    public static function foreignKey():array
    {
        return ['category'=>Category::class];
    }
    public static function hasMany():array {
        return ['category'=>Category::class];
    }


    #[ArrayShape(['name' => "array"])] public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }
}