<?php


namespace App\core\exception;

use PDOException;

class QueryException extends PDOException
{
    protected string $sql;

    protected array $bindings;

    public function __construct($sql, array $bindings, \Throwable $previous)
    {
        parent::__construct('', 0, $previous);

        $this->sql = $sql;
        $this->bindings = $bindings;
        $this->code = $previous->getCode();
        $this->message = $this->formatMessage($sql, $bindings, $previous);

        if ($previous instanceof PDOException) {
            $this->errorInfo = $previous->errorInfo;
        }
    }

    protected function formatMessage($sql, $bindings, \Throwable $previous):string
    {
        return $previous->getMessage();
    }

    public function getSql():string
    {
        return $this->sql;
    }

    public function getBindings():array
    {
        return $this->bindings;
    }
}