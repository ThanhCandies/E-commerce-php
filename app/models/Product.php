<?php


namespace App\models;


use App\core\DbModel;
use JetBrains\PhpStorm\ArrayShape;

class Product extends DbModel
{
    public int|null $id = 0;
    public string $name = '';
    public bool|null $published = false;
    public int $price = 0;
    public int|object|null $category = 0;
    public int|null|object $image = 0;

    protected string $table = 'products';

    public static function attributes(): array
    {
        return ['id', 'name', 'published', 'price', 'category'];
    }

    public static function foreignKey(): array
    {
        return ['category' => Category::class];
    }

    #[ArrayShape(['name' => "array"])] public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }
}