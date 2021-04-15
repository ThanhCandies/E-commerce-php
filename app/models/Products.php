<?php


namespace App\models;


use App\core\DbModel;
use JetBrains\PhpStorm\ArrayShape;

class Products extends DbModel
{
    public int|null $id = 0;
    public string $name = '';
    public bool $published = false;
    public int $price = 0;
    public int|object|null $category = 0;

    public static function tableName(): string
    {
        return 'products';
    }

    public function attributes(): array
    {
        return ['name', 'published', 'price'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    #[ArrayShape(['name' => "array"])] public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }
}