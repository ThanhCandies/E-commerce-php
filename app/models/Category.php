<?php


namespace App\models;


class Category extends \App\core\DbModel
{
    public string $name ='';
    public string $descriptions = '';
    public $image='';


    public static function tableName(): string
    {
        return 'categories';
    }

    public function attributes(): array
    {
       return ['name','description','image'];
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