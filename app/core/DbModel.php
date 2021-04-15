<?php

namespace App\core;

abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

    /**
     * @param $attr
     * @return false|string|int|
     */
    public function getAttr($attr): bool|int|string
    {
        return $this->{$attr} ?? false;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);
            $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(",", $params) . ");");

            foreach ($attributes as $attribute) {
                $param_type = match (gettype($this->{$attribute})) {
                    "boolean" => \PDO::PARAM_BOOL,
                    "integer" => \PDO::PARAM_INT,
                    "string" => \PDO::PARAM_STR,
                    default => \PDO::PARAM_NULL
                };
//                dump(["$attribute"=>$param_type,"type"=>gettype($attribute),"value"=>$this->{$attribute}]);
                $statement->bindValue(":$attribute", $this->{$attribute}, $param_type);
            }
//            dd('stop');
            $statement->execute();
            return true;
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    public function update($val = null): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $primaryKey = $this->primaryKey();
        $value = $val ?? $this->{$primaryKey};

        $params = array_map(fn($attr) => "$attr = :$attr");

        $statement = self::prepare("UPDATE $tableName SET" . implode(', ', $params) . " WHERE $primaryKey = $value;");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attributes", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function delete($val = null): bool
    {
        $tableName = $this->tableName();
        $primaryKey = $this->primaryKey();
        $value = $val ?? $this->{$primaryKey};

        $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = $value;");
        $statement->execute();
        return true;
    }

    public static function prepare($sql): bool|\PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public static function findOne(array $where, $options = "AND", array $props = [])
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $combine = " " . $options . " ";
        $whereSQL = implode($combine, array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $whereSQL;");

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function findAll($filter, array $props = []): array
    {
        /**
         * @var $pagination array
         */
        $tableName = static::tableName();
        $pagination = Application::$app->request->getPagination();

        $filter = '';
        if ((int)$pagination['limit'] !== 0) {
            $max = $pagination['limit'] > 100 ? 100 : $pagination['limit'];
            $filter = $filter . "LIMIT " . $max;
        }
        if ((int)$pagination['page'] && $pagination['limit'] !== 0) {
            $offset = ($pagination['page'] - 1) * $pagination['limit'];
            $filter = $filter . "OFFSET " . $offset;
        }

        $statement = self::prepare("SELECT * FROM $tableName " . $filter);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function count($filter): int
    {
        $tableName = static::tableName();
        $stmt = self::prepare("SELECT COUNT(*) AS totalRecord FROM $tableName");
        $stmt->execute();
        return (int)$stmt->fetch()['totalRecord'];
    }
}
