<?php


namespace App\models;


class Category extends \App\core\DbModel
{
    public int|null $id = 0;
    public string $name ='';
    public string $description = '';
    public bool $published = false;
    public int|null|object $image = 0;
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