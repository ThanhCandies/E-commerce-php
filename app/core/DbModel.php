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
    public function getAttr($attr)
    {
        return $this->{$attr} ?? false;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(",", $params) . ");");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function update($value)
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $primaryKey = $this->primaryKey();

        $params = array_map(fn($attr) => "$attr = :$attr");

        $statement = self::prepare("UPDATE $tableName SET" . implode(', ', $params) . " WHERE $primaryKey = $value;");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attributes", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function delete($value)
    {
        $tableName = $this->tableName();
        $primaryKey = $this->primaryKey();
        $statement = self::prepare("DELETE FROM $tableName WHERE $primaryKey = $value;");
        $statement->execute();
        return true;
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public static function findOne(array $where, $options = "AND")
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

    public static function findAll(array $props = [])
    {
        /**
         * @var $paginations array
         */
        $tableName = static::tableName();
        $paginations = Application::$app->request->getPagination();


        $stmt = self::prepare("SELECT COUNT(*) AS totalRecord FROM $tableName");
        $stmt->execute();
        $totalRecord = (int)$stmt->fetch()['totalRecord'];

        $limit = $paginations['limit'];
        $maxPages = ceil($totalRecord / $limit);
        $page = $paginations['page'] > $maxPages ? $maxPages : $paginations['page'];
        $offset = ($page - 1) * $limit;

        $statement = self::prepare("SELECT * FROM $tableName LIMIT $limit OFFSET $offset");
        $statement->execute();
        $data = $statement->fetchAll(\PDO::FETCH_CLASS, static::class);

        $hasMany = false;

        if (!empty($props)) {
            // Get roles


            foreach ($data as $item) {
                // role,
                foreach ($props as $key) {
                    $foreignTable = $item::foreignKey()[$key];

                    $sql = "SELECT * FROM " . $foreignTable::tableName() . " WHERE " . $foreignTable::primaryKey() . " = " . $item->{$key};
                    $statement = self::prepare($sql);
                    $statement->execute();

                    if ($hasMany) {
                        $item->{$key} = $statement->fetchAll(\PDO::FETCH_CLASS, $foreignTable);
                    } else {
                        $item->{$key} = $statement->fetchObject($foreignTable);
                    }
                }
            }
        }

        return ['data' => $data,
            'limit' => $limit,
            'totalRecord' => $totalRecord,
            'page' => $page,
            'maxPages' => $maxPages
        ];
    }
}
