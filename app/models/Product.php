<?php


namespace App\models;


use App\core\DbModel;
use JetBrains\PhpStorm\ArrayShape;

class Product extends DbModel
{
    public string $table = 'products';

    protected array $fillable = [
        'name',
        'price',
        'category_id',
        'image_id',
        'published',

    ];


    #[ArrayShape(['name' => "array"])] public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }
}

/**
 * @param
 */