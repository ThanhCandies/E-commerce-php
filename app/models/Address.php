<?php


namespace App\models;


class Address extends \App\core\DbModel
{
    public string $table = 'address';
    protected array $fillable = [
        'user_id',
        'address'
    ];

}