<?php


namespace App\core\Database;

class Grammar
{
    protected array $selectComponents = [
        'aggregate',
        'columns',
        'from',
        'joins',
        'wheres',
        'groups',
        'havings',
        'orders',
        'limit',
        'offset',
        'lock',
    ];
    protected string $tablePrefix = '';

    public function compileSelect(QueryBuilder $query): string
    {

        $original = $query->columns;
        if (is_null($query->columns)) {
            $query->columns = ['*'];
        }

        $sql = $this->compileComponents($query);

//        return $sql;
        return 'Select * from images';
    }

    public function compileComponents(QueryBuilder $query)
    {
        $sql = [];

        foreach ($this->selectComponents as $component) {
            if (isset($query->$component)) {
                $method = 'compile' . ucfirst($component);

                $sql[$component] = $this->$method($query, $query->$component);
            }
        }

        return $sql;
    }

    protected function compileColumns(QueryBuilder $query, $columns): string
    {
        if (!is_null($query->aggregate)) {
            return '';
        }

        if ($query->distinct) {
            $select = 'select distinct ';
        } else {
            $select = 'select ';
        }

        return $select . $this->columnize($columns);
    }


    protected function compileUnionAggregate(QueryBuilder $query): string
    {
        $sql = $this->compileAggregate($query, $query->aggregate);

        $query->aggregate = null;

        return $sql . ' from (' . $this->compileSelect($query) . ') as ';
//            .$this->wrapTable('temp_table');
    }

    protected function compileAggregate(QueryBuilder $query, $aggregate): string
    {
        $column = $this->columnize($aggregate['columns']);

        if (is_array($query->distinct)) {
            $column = 'distinct ' . $this->columnize($query->distinct);
        } elseif ($query->distinct && $column !== '*') {
            $column = 'distinct ' . $column;
        }

        return 'select ' . $aggregate['function'] . '(' . $column . ') as aggregate';
    }

    public function columnize(array $columns): string
    {
        return implode(', ', array_map([$this, 'wrap'], $columns));
    }

    public function wrap($value, $prefixAlias = false)
    {
        return $this->wrapSegments(explode('.', $value));
    }

    public function wrapSegments($segments)
    {
        return collect($segments)->map(function ($segment, $key) use ($segments) {
            return $key == 0 && count($segments) > 1
                ? $this->wrapTable($segment)
                : $this->wrapValue($segment);
        })->implode('.');
    }

    public function wrapTable($table):string
    {
        return $this->wrap($this->tablePrefix . $table, true);
    }

    protected function wrapValue($value):string
    {
        if ($value !== '*') {
            return '"' . str_replace('"', '""', $value) . '"';
        }

        return $value;
    }
}