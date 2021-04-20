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
    public static function attributes(): array
    {
        return ['role'];
    }

}