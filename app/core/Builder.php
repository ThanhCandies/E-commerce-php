<?php


namespace App\core;


trait Builder
{
    public array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>',
        'rlike', 'not rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];
    protected array $select = [];
    protected array $from = [];
    protected array $where = [];
    protected array $groupBy = [];
    protected array $having = [];
    protected array $orderBy = [];
    protected int $limit;
    protected int $offset;

    public function select($fields = ['*'])
    {
        $fields = is_array($fields) ? $fields : func_get_args();

        $this->addSelect($fields);

        return $this;
    }
    public function from($tables)
    {
        $tables = is_array($tables) ? $tables : func_get_args();

        $this->addFrom($tables);

        return $this;
    }
    public function where(...$params)
    {
        return $this->andWhere(...$params);
    }
    public function andWhere(...$params)
    {
        return $this->whereLogicOperator('and', ...$params);
    }

    public function orWhere(...$params)
    {
        return $this->whereLogicOperator('or', ...$params);
    }
}