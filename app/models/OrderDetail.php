<?php


namespace App\models;


class OrderDetail extends \App\core\DbModel
{
    public string $table = 'orderdetails';

    protected array $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'count',
        'price',
        'total'
    ];
}