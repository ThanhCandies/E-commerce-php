<?php


namespace App\models;


use App\core\DbModel;

class Role extends DbModel
{
    public string $role = '';



    public function rules(): array
    {
        return [
            'role'=>[self::RULE_REQUIRED]
        ];
    }
    public function attributes(): array
    {
        return ['role'];
    }
    public static function tableName(): string
    {
        return 'roles';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}