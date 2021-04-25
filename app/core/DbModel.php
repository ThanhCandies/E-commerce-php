<?php

namespace App\core;

use App\core\Query\Builder as QueryBuilder;
use JetBrains\PhpStorm\Pure;
use \JsonSerializable;

/**
 * @method static Collections get(array $columns = ['*'])
 * @method static QueryBuilder select(array|string ...$columns)
 * @method static QueryBuilder distinct($bool = true)
 * @method static QueryBuilder where(array|string $column, $operator = null, $value = null)
 * @method static QueryBuilder count(string $column = null)
 * @method static QueryBuilder whereIn(string $column, array $value)
 * @method static QueryBuilder orWhere($bool = true)
 * @method static QueryBuilder join(string $table, string $first, string $operator, string $second, string $type, bool $where)
 * @method static QueryBuilder all(array $columns = ['*'])
 * @method static QueryBuilder groupBy(array|string $columns)
 * @method static QueryBuilder orderBy($bool = true)
 * @method static QueryBuilder limit(int $limit)
 * @method static QueryBuilder offset(int $offset)
 * @method static static create(array $attributes = [])
 * @method static QueryBuilder update(array $attributes = [])
 * @method static QueryBuilder insert(array $attributes = [],$getId = false)
 * @method static QueryBuilder upsert(array $attributes = [])
 * @method static QueryBuilder insertGetId(array $attributes = [])
 * @method static QueryBuilder save()
 * @method static static find(int|null $id)
 */
abstract class DbModel extends Model
{
    public function rules(): array
    {
        return [];
    }

    public function __construct(array $attributes = [])
    {
        if(!empty($attributes)) $this->fill($attributes);
    }

    public static function prepare($sql): bool|\PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

}
