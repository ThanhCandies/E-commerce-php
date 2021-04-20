<?php

namespace App\core;

use App\core\Query\Builder as QueryBuilder;
use JetBrains\PhpStorm\Pure;
use \JsonSerializable;

/**
 * @method static Collections get(array $columns = ['*'])
 * @method static QueryBuilder select(array|string $columns)
 * @method static QueryBuilder distinct($bool = true)
 * @method static QueryBuilder where($bool = true)
 * @method static QueryBuilder count(string $column=null)
 * @method static QueryBuilder whereIn(string $column,array $value)
 * @method static QueryBuilder orWhere($bool = true)
 * @method static QueryBuilder join(string $table,string $first,string $operator,string $second,string $type,bool $where)
 * @method static QueryBuilder all(array $columns = ['*'])
 * @method static QueryBuilder groupBy(array|string $columns)
 * @method static QueryBuilder orderBy($bool = true)
 * @method static QueryBuilder limit(int $limit)
 * @method static QueryBuilder offset(int $offset)
 * @method static static create(array $attributes=[])
 * @method static QueryBuilder update(array $attributes=[])
 * @method static QueryBuilder insert(array $attributes=[])
 * @method static QueryBuilder upsert(array $attributes=[])
 * @method static QueryBuilder insertGetId(array $attributes=[])
 * @method static QueryBuilder save()
 * @method static static find(int|null $id)
 */

abstract class DbModel extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function getAttr($attr): bool|int|string
    {
        return $this->{$attr} ?? false;
    }

//    public function save(): bool
//    {
//        try {
//            $tableName = $this->getTable();
//            $attributes = $this->attributes();
//            $params = array_map(fn($attr) => ":$attr", $attributes);
//            $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(",", $params) . ");");
//
//            foreach ($attributes as $attribute) {
//                $param_type = match (gettype($this->{$attribute})) {
//                    "boolean" => \PDO::PARAM_BOOL,
//                    "integer" => \PDO::PARAM_INT,
//                    "string" => \PDO::PARAM_STR,
//                    default => \PDO::PARAM_NULL
//                };
//                $statement->bindValue(":$attribute", $this->{$attribute}, $param_type);
//            }
//            $statement->execute();
//            return true;
//        } catch (\Exception $exception) {
//            dd($exception);
//        }
//    }

//    public function update($val = null): bool
//    {
//        $tableName = $this->getTable();
//        $attributes = $this->attributes();
//        $primaryKey = $this->getKeyName();
//        $value = $val ?? $this->{$primaryKey};
//
//        $params = array_map(fn($attr) => "$attr = :$attr");
//
//        $statement = self::prepare("UPDATE $tableName SET" . implode(', ', $params) . " WHERE $primaryKey = $value;");
//
//        foreach ($attributes as $attribute) {
//            $statement->bindValue(":$attributes", $this->{$attribute});
//        }
//        $statement->execute();
//        return true;
//    }

    public function delete($val = null): bool
    {
        $tableName = $this->getTable();
        $primaryKey = $this->getKeyName();
        $value = $val ?? $this->{$primaryKey};

        $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = $value;");
        $statement->execute();
        return true;
    }

    public static function prepare($sql): bool|\PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    #[Pure] public function attributeArray():array
    {
        if (empty($this->hidden)) {
            return $this->attributes;
        } else {
            $attributes = [];

            foreach ($this->attributes as $key => $value) {
                if (!in_array($key, $this->hidden)) {
                    $attributes[$key] = $value;
                }
            }
            return $attributes;
        }
    }



    public static function findOne(array $where, $options = "AND", array $props = [])
    {
        $tableName = static::getTable();
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

    public static function findAll(array $props = []): array
    {
        /**
         *  Need refactor
         * @var $pagination array
         */

        $tableName = static::getTable();
        $attributes = static::attributes();
        $foreign = method_exists(static::class, 'foreignKey') ? static::foreignKey() : [];

        $pagination = Application::$app->request->getPagination();
        $sortParams = $pagination['sort_by'] ?? [];

        $attr = implode(",", array_map(fn($a) => "$tableName.$a", $attributes));
        $arr = ["ASC", "DESC"];
        $order = [];
        $filter = $join = "";

        // SORT
        if (is_array($sortParams)) {
            foreach ($sortParams as $key => $value) {
//                dd(explode('.', $key)[0],$attributes,$foreignTable);
                if (!in_array(strtoupper($value), $arr)) continue;
                if (in_array($key, $attributes)) {
                    $order[] = "$key $value";
                }
                $separate = explode('.', $key);
                if (in_array($separate[0], $props)) {
                    array_shift($separate);
                    $table = $foreign[explode('.', $key)[0]]::tableName();
                    $order[] = "$table." . implode(".", $separate) . " $value";
                }
//                dd($order);
            }
        }

        $orderQuery = empty($order) ? "" : " ORDER BY " . implode(" ,", $order);

        if ((int)$pagination['length'] !== 0) {
            $max = $pagination['length'] > 100 ? 100 : $pagination['length'];
            $filter = $filter . " LIMIT " . $max;
        }
        if ((int)$pagination['page'] && $pagination['length'] !== 0) {
            $offset = ($pagination['page'] - 1) * $pagination['length'];
            $filter = $filter . " OFFSET " . $offset;
        }

        // Search;
        $search = array_intersect_key(Application::$app->request->getBody(), array_flip($attributes));
        $searchKey = array_keys($search);
        $whereSql = empty($searchKey) ? "" : " WHERE " . implode(' OR ', array_map(fn($attr) => "$tableName.$attr REGEXP :$attr", $searchKey));

        // JOIN Table
        foreach ($props as $key) {
            $class = $foreign[$key];
            $table = $class::tableName();

            $foreignTable[] = $table;
            $join = $join . "INNER JOIN " . $table . " ON $tableName.$key=" . $table . "." . $class::primaryKey();
        }

        $statement = self::prepare("SELECT $attr FROM $tableName $join $whereSql $orderQuery" . $filter);
        foreach ($search as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_CLASS, static::class);

        // Search nested object;
        foreach ($props as $key) {
            $class = $foreign[$key];
            $table = $class::tableName();

            $unique = array_unique(array_column($data, $key));
            $whereSQL = implode(" OR ", array_map(fn($att) => $class::primaryKey() . " = $att", $unique));

            $stmt = self::prepare("SELECT * FROM $table WHERE $whereSQL");
            $stmt->execute();
            $nestedObj = $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
            foreach ($data as $instanceK => $instance) {
                $instance->{$key} = $nestedObj[array_search($instance->{$key}, array_column($nestedObj, $class::primaryKey()))];
            }
        }
        return $data;
    }

//    public static function count($filter = ''): int
//    {
//        $tableName = static::tableName();
//        $stmt = self::prepare("SELECT COUNT(*) FROM $tableName");
//        $stmt->execute();
//        return (int)$stmt->fetchColumn();
//    }

}
