<?php


namespace App\core\Query;


class Builder
{
    use QueryBuilder;

//    public static function __callStatic($method, $parameters)
//    {
//        dump($method,$parameters);
//        return (new static)->$method(...$parameters);
//    }
//
//    public function __call($method, $parameters)
//    {
//        dump($method,$parameters,'s');
//
//        if (in_array($method, ['increment', 'decrement'])) {
//            return $this->$method(...$parameters);
//        }
//        // $this->newQuery() - Tạo một query mới.
//        return $this->forwardCallTo(new static, $method, $parameters);
//    }
}