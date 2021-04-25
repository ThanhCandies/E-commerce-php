<?php


namespace App\models;


class Order extends \App\core\DbModel
{
    public string $table = 'orders';
    protected array $fillable = [
        'user_id',
        'status',
        'message',
        'address'
    ];
}