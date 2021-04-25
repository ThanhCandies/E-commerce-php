<?php


namespace App\models;


class Category extends \App\core\DbModel
{
    protected string $table = 'categories';
    protected array $fillable = [
        'name',
        'description',
        'image_id',
        'published',

    ];

    public function rules(): array
    {
        return [];
    }
}