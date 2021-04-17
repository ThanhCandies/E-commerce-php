<?php


namespace App\models;


class Category extends \App\core\DbModel
{
    public int|null $id = 0;
    public string $name ='';
    public string $descriptions = '';
    public $image='';


    public static function tableName(): string
    {
        return 'categories';
    }

    public static function attributes(): array
    {
       return ['id','name','description','image'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }
}