<?php


namespace App\core\Query;


use App\core\Application;
use App\core\Collections;
use App\core\Database;
use App\core\Model;
use http\Exception;
use Illuminate\Support\Traits\ForwardsCalls;
use JetBrains\PhpStorm\Pure;

trait QueryBuilder
{
    use ForwardsCalls;

    /** Product::where()->get(); */
    public Database $connection;
    public object $grammar;
    public Model $model;

    protected int $fetchType = \PDO::FETCH_OBJ;

    protected array|null $columns = null;
    protected string|array|null $from = null;
    protected array|null $where = null;
    protected array|null $groupBy = null;
    protected array $having = [];
    protected array $orderBy;
    protected array $joins = [];
    protected array $attributes = [];
    protected bool $distinct = false;
    protected int|null $limit = null;
    protected int|null $offset = null;
    protected string $count;
    protected array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>',
        'rlike', 'not rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];
    protected array $comparisons = [
        'equal' => '=',
        'not_equal' => '<>',
        'not_equal_other' => '!=',
        'less' => '<',
        'less_or_equal' => '<=',
        'greater' => '>',
        'greater_or_equal' => '>=',
        'like' => 'like',
        'in' => 'in',
        'not_in' => 'not in',
        'between' => 'between',
        'not_between' => 'not between',
    ];
    public array $bindings = [
        'select' => [],
        'from' => [],
        'join' => [],
        'where' => [],
        'groupBy' => [],
        'having' => [],
        'order' => [],
        'union' => [],
        'unionOrder' => [],
    ];
    protected array $eagerLoad = [];

    public function __construct(Database $connection = null)
    {
        $this->connection = $connection ?: Application::$app->db;
    }

    protected function setTable($table)
    {
        $this->from = $table;
    }

    public static function table($table): static
    {
        $builder = new static();
        $builder->from = $table;
        return $builder;
    }

    public function create($attributes = []): Model
    {
        return $this->getModel()->fill($attributes);
    }

    public function select($columns = ['*']): static
    {
//        $this->columns = [];
        $this->bindings['select'] = [];
        $columns = is_array($columns) ? $columns : func_get_args();

        foreach ($columns as $as => $column) {
            $this->columns[] = $column;
        }

        return $this;
    }

    public function distinct($bool = true): static
    {
        $this->distinct = $bool;
        return $this;
    }

    public function join($table = null, $first = null, $operator = null, $second = null, $type = "INNER", $where = false): static
    {
        if (empty(func_get_args())) return $this;
        $method = $where ? 'where' : 'on';
        $this->joins[] = [$table, $first, $operator, $second, $type];
        return $this;
    }

    public function where($columns, $operator = null, $value = null, $boolean = "AND"): static
    {
//         dump($columns, $operator,$value);
        if (!in_array($operator, $this->operators)
            && !in_array(strtolower($operator), $this->comparisons)) {
            $value = $operator;
            $operator = '=';
        }
        if (!$value) return $this;
        $this->where[] = compact('columns', 'operator', 'value', 'boolean');
        $this->bindings['where'][] = $value;
        return $this;
    }

    public function orWhere($columns, $operator, $value = null): static
    {
        return $this->where($columns, $operator, $value, 'or');
    }

    public function whereBetween($column, array $attribute)
    {

    }

    public function whereIn($column, array $attributes): static
    {
        return $this->where($column, 'IN', array_unique($attributes));
    }

    public function groupBy($columns): static
    {
        $this->groupBy = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function orderBy($column, $direction = 'asc'): static
    {
        $this->orderBy[] = [$column, $direction];
        return $this;
    }

    public function orderByDesc($column): static
    {
        return $this->orderBy($column, 'desc');
    }

    public function limit(int $limit): static
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): static
    {
        $this->offset = $offset;
        return $this;
    }


    public function leftJoin($table, $first, $operator, $second): static
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    public function outerJoin($table, $first, $operator, $second): static
    {
        return $this->join($table, $first, $operator, $second, 'LEFT OUTER');
    }

    public function crossJoin(): static
    {
        return $this;
    }


    public function count($columns = ['*'])
    {
        if (!isset($this->from) || empty($this->from)) {
            return 0;
        }
        $sql = $this->distinct ? 'SELECT DISTINCT' : 'SELECT';
        $sql .= " COUNT(" . implode(', ', $columns) . ")";

        $sql .= ' FROM ' . $this->from;

        $sql .= $this->compileJoin();
        $sql .= $this->compileWhere();
        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUpdateAttributes($attribute): array
    {
        $model = $this->getModel();
        $attributes = array_merge($model->getUpdate(), $attribute);
        unset($attributes[$model->getKeyName()], $attributes['create_at'], $attributes['update_at']);

        return $attributes;
    }

    public function getInsertAttributes($inserts, $unsetPrimaryKey = true): array
    {
        $model = $this->getModel();

        $attributes = array_intersect_key(array_merge($model->getAttributes(), $inserts), array_flip($model->getFillable()));

        if ($unsetPrimaryKey) unset($attributes[$model->getKeyName()]);
        unset($attributes['create_at'], $attributes['update_at']);

        return $attributes;
    }

    public function save()
    {
        if ($this->getModel()->exists) {
            return $this->update();
        } else {

            return $this->insert(); // Editing here!!
        }
    }

    public function attributes($attribute)
    {
        $this->attributes = is_array($attribute) ? $attribute : func_get_args();
        return $this;
    }

    public function insertMany(array $inserts)
    {
        if (!$this->from ?? true) throw new \Exception('No table');
        $prepare = "(" . implode(', ', array_map(fn() => '?', $this->attributes)) . ")";

        $sql = "INSERT INTO " . $this->from . " (" . implode(', ', $this->attributes) . ") VALUES " . implode(', ', array_fill(0,count($inserts),$prepare));
        $bindings = array();
        array_walk_recursive($inserts, function ($value, $key) use (&$bindings) {
            $bindings[] = $value;
        }, $bindings);
//        dd($sql);

        return $this->connection->save($sql, $bindings);
    }

    public function insert($attributes = [], $getId = false, $upsert = false)
    {
        $inserts = $this->getInsertAttributes($attributes, !$upsert);
        if (empty($inserts)) return true;

        $model = $this->getModel();
        $key = array_keys($inserts);
        $inserts = array_combine(
            array_map(function ($k) {
                return ':' . $k;
            }, array_keys($inserts)),
            $inserts
        );
        $sql = "INSERT INTO " . $model->getTable() . " (" . implode(', ', $key) . ") VALUES ("
            . implode(',', array_keys($inserts)) . ')';

        if ($upsert) {
            $sql .= " ON DUPLICATE KEY UPDATE " . implode(', ', array_map(fn($k) => "$k = :$k" . "2", $key));
            $upserts = array_flip(array_map(function ($v) {
                return $v . "2";
            }, array_flip($inserts)));

            $inserts = array_merge($inserts, $upserts);
        }
        return $this->connection->save($sql, $inserts, $getId);
    }

    public function insertGetId($attribute = [])
    {
        return $this->insert($attribute, true);
    }

    public function update($attributes = [])
    {
        $model = $this->getModel();
        $insert = $this->getInsertAttributes($attributes, false);


        if (empty($insert)) return true;

        $updateKey = array_keys($insert);
        $updateValue = array_values($insert);
        $key = $model->getKeyName();


        $sql = 'UPDATE ' . $model->getTable() .
            ' SET ' . implode(', ', array_map(fn($key) => "$key = ?", $updateKey)) .
            ' WHERE ' . $key . ' = ' . $model->{$key};

        return $this->connection->save($sql, $updateValue);
    }

    public function upsert($attributes = [])
    {
        return $this->insert($attributes, true, true);
    }

    public function delete(array|string|int|null $values, $getRow = false): bool|int|\PDOStatement
    {
        $model = $this->getModel();

        $table = $model->getTable();
        $key = $model->getKeyName();

        $value = $model->{$key} ?? null;

        $query = "DELETE FROM $table WHERE";
        $bindings = [];
        if ($value) {
            $query .= " $key = ?";
            $bindings[] = $value;
        } else if (!empty($values = is_array($values) ? $values : [$values])) {
            $bindings = $values;
            $query .= " $key IN (" . implode(', ', array_map(fn() => '?', $values)) . ")";
        } else if (!empty($bindings = array_merge($values, $this->bindings['where']))) {
            $query .= $this->compileWhereBind();
        };

        if (empty($bindings)) return false;
        return $this->connection->delete($query, $bindings);
    }

    public function compileWhereBind()
    {
        $sql = '';
        if (isset($this->where) && is_array($this->where)) {
            foreach ($this->where as $wk => $val) {
                if ($wk > 0) {
                    $sql .= ' ' . (strtolower($val['boolean']) === 'and' ? "AND" : "OR");
                }
                $value = is_array($val['value']) ? (" (" . implode(', ', array_map(fn() => "?", $val['value'])) . ")") : " ?";

                $column = empty($this->joins) && str_contains($val['columns'], '.')
                    ? $val['columns']
                    : $this->getModel()->getTable() . '.' . $val['columns'];

                $sql .= " "
                    . $column . " "
                    . $val['operator'] . " "
                    . $value;
            }
            return $sql;
        } else {
            return false;
        }
    }

    public function find($id): Model|bool|static
    {
        if (!$id) return $this;
        $model = $this->getModel();

        $query = "SELECT * FROM " . $model->getTable() . " WHERE " . $model->getKeyName() . " = $id";
        $data = $this->connection->find($query);

        return $data ? $model->newFormBuilder((array)$data) : $data;
    }

    public function first()
    {
        if (!isset($this->where) || empty($this->where)) return false;
        $model = $this->getModel();

        $query = "SELECT * FROM " . $model->getTable() . " WHERE";
        foreach ($this->where as $key => $value) {
            if ($key > 0) {
                $query .= " " . $value['boolean'];
            }
            $query .= " " . $value['columns'] . " " . $value['operator'] . " ?";
        }

        //'columns', 'operator', 'value', 'boolean'
        $bindings = array_column($this->where, 'value');

        $data = $this->connection->selectOne($query, $bindings);

        return $data ? $model->newFormBuilder($data) : $data;
    }

    public function getFromDatabase($columns = ['*'])
    {
        if (!isset($this->from) || empty($this->from)) {
            return false;
        }
        $sql = $this->distinct ? 'SELECT DISTINCT' : 'SELECT';
        $sql .= $this->compileColumn($columns);

        $sql .= ' FROM ' . $this->from;

        $sql .= $this->compileJoin();
        $sql .= $this->compileWhere();
        if (!($this->count ?? false)) {
            $sql .= $this->compileOrderBy();
            $sql .= $this->compileLimit();
            $sql .= $this->compileOffset();
        }

        if (!($this->count ?? false)) {
            $models = $this->connection->select($sql);
//            dump($sql);
            return !isset($this->model) ? $models : collect($models);
        }

        $stmt = $this->connection->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();

    }

    /**
     * @param string[] $columns
     * @return Collections
     */
    public function get($columns = ['*']): Collections
    {
        if (count($models = $this->getModels($columns)) > 0) {
//            $models = $this->eagerLoadRelations($models);
        };

        return $this->getModel()->newCollection($models);
    }


    public function with($relations): static
    {
        $eagerLoad = $this->parseWithRelation(is_string($relations) ? func_get_args() : $relations);
        $this->eagerLoad = array_merge($this->eagerLoad, $eagerLoad);
        return $this;
    }

    public function parseWithRelation(array $relations): array
    {
        $results = [];
        foreach ($relations as $name => $constraints) {
            $name = $constraints;
            [$name, $constraints] = [$name, static function () {
            }];

            $results[$name] = $constraints;
        }
        return $results;
    }

    public function getRelation($name)
    {
        $relation = $this->getModel()->newInstance()->$name();
        return $relation;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getModels($columns = ['*'])
    {
        return $this->model->hydrate(
            $this->getFromDatabase($columns)->all()
        )->all();
    }

    public function hydrate(array $items)
    {
        $instance = $this->newModelInstance();
        return $instance->newCollection(array_map(function ($item) use ($instance) {
            return $instance->newFormBuilder($item);
        }, $items));
    }

    public function compileLimit(): string
    {
        $sql = '';
        if (isset($this->limit)) $sql .= " LIMIT $this->limit";
        return $sql;
    }

    public function compileOffset(): string
    {
        $sql = '';
        if (isset($this->offset)) $sql .= " OFFSET $this->offset";
        return $sql;
    }

    public function compileColumn($columns): string
    {
        $sql = '';
        if ($this->count ?? false) {
            return " COUNT(" . implode(', ', $columns) . ")";
        }


        if (isset($this->columns) && is_array($this->columns)) {
            $sql .= ' ' . implode(', ', $this->columns);
        } else if (is_string($columns)) {
            $sql .= ' ' . $columns;
        } else if (is_array($columns)) {
            $sql .= ' ' . implode(', ', $columns);
        }
        return $sql;
    }

    public function compileJoin(): string
    {
        $sql = '';
        if (isset($this->joins) && is_array($this->joins)) {
            $case = ['INNER', 'LEFT', 'RIGHT', 'LEFT OUTER', 'RIGHT OUTER'];
            foreach ($this->joins as $join) {
                if (in_array(strtoupper($join[4]), $case)) {
                    $sql .= ' ' . $join[4] . ' JOIN';
                } else {
                    $sql .= ' INNER JOIN';
                }
                $sql .= " $join[0] ON $join[1] $join[2] $join[3]";
            }
        }
        return $sql;
    }

    public function compileWhere()
    {
        $sql = '';
        if (isset($this->where) && is_array($this->where)) {
            $sql .= ' WHERE';
            foreach ($this->where as $wk => $val) {
                if ($wk > 0) {
                    $sql .= ' ' . (strtolower($val['boolean']) === 'and' ? "AND" : "OR");
                }
                $value = is_array($val['value']) ? ("(" . implode(',', $val['value']) . ")") : $val['value'];

                $column = empty($this->joins) && str_contains($val['columns'], '.')
                    ? $val['columns']
                    : $this->getModel()->getTable() . '.' . $val['columns'];

                $sql .= " "
                    . $column . " "
                    . $val['operator'] . " "
                    . $value;
            }
        }
        return $sql;
    }

    public function compileOrderBy()
    {
        $sql = '';
        if (isset($this->orderBy) && is_array($this->orderBy)) {
            $sql .= ' ORDER BY';
            $sql .= implode(",", array_map(fn($order) => " $order[0] $order[1]", $this->orderBy));
        }
        return $sql;
    }

    public function setModel($model): static
    {
        if ($model instanceof Model) {
            $this->model = $model;
        } else {
            $this->model = new $model();
        }

        $this->from = $this->model->getTable();
        return $this;
    }

    /**
     * Create a new instance of the model being queried.
     *
     * @param array $attributes
     * @return Model|static
     */
    public function newModelInstance($attributes = []): Model|static
    {
        return $this->model->newInstance($attributes);
    }


}