<?php


namespace App\models;


use App\core\DbModel;

class Permission extends DbModel
{
    public static function tableName(): string
    {
        return 'permissions';
    }
    public static function primaryKey(): string
    {
        return 'id';
    }
    public function rules(): array
    {
        return [];
    }
    public function attributes(): array
    {
        return [];
    }
}