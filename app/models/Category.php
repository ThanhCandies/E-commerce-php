<?php


namespace App\models;


class Category extends \App\core\DbModel
{
    protected string $table = 'categories';

    public static function attributes(): array
    {
       return ['id','name','description','image','published'];
    }

    public function rules(): array
    {
        return [];
    }
}