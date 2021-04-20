<?php

namespace App\core;

use App\core\Query\HasRelationsShip;
use App\core\support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use JetBrains\PhpStorm\Pure;
use App\core\Query\Builder as QueryBuilder;

abstract class Model implements \JsonSerializable
{
    use ForwardsCalls;
    use HasRelationsShip;
    use Str;

    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_UNIQUE = "unique";
    public const RULE_MATCH = "match";
    public const RULE_TYPE = "type";
    protected $with = [];
    protected string $table;
    protected string $primaryKey = 'id';

    protected bool $success = true;
    protected array $errors = [];

    protected array $attributes = [];
    protected array $relations = [];

    protected array $hidden = [];
    protected array $fillable = [];
    protected bool $exists = false;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                settype($value, gettype($this->{$key}));
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;


    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorWithRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorWithRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorWithRule($attribute, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorWithRule($attribute, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorWithRule($attribute, self::RULE_MATCH, $rule);
                }
                if ($ruleName === self::RULE_TYPE) {
                    $accept = $rule['accept'];
                    $listAccept = explode('|', $accept);
                    if (!in_array($value, $listAccept)) {
                        $this->addErrorWithRule($attribute, self::RULE_TYPE, ['type' => $accept]);
                    };
                }

                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr='$value'");
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addErrorWithRule($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                    }
                }
            }
        }
        if (empty($this->errors)) {
            return true;
        } else {
            $this->success = false;
            return false;
        }
        // return !empty($this->errors)?:$this->success=false;
    }

    public function addErrorWithRule(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
            self::RULE_TYPE => 'Files upload must be {type}'
        ];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->error[$attribute][0] ?? false;
    }

    public function fill($attributes = []): static
    {
        foreach ($attributes as $key => $value) {
            $this->setAttributes($key, $value);
        }
        return $this;
    }

    public function setAttributes($key, $value): static
    {
        $this->attributes[$key] = $value;
        return $this;
    }
    #[Pure] public function getAttribute($attribute):mixed
    {
        return $this->getAttributes()[$attribute];
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getRelations($name): array
    {
        return $this->relations[$name];
    }

    /**
     * @param array $relations
     * @param string $name
     */
    public function setRelations(string $name,array $relations): void
    {
        $this->relations[$name] = $relations;
    }
    public function setRelation(string $name,$relation): void
    {
        $this->relations[$name] = $relation;
    }



    #[Pure] public function newCollection($models): Collections
    {
        return new Collections($models);
    }

    public static function query(): QueryBuilder
    {
        return (new static)->newQuery();
    }

    public function newQuery(): QueryBuilder
    {
        return $this->newModelQuery();
    }

    public function newModelQuery(): QueryBuilder
    {
        return $this->newBuilder(Application::$app->db)->setModel($this);
    }

    #[Pure] public function newBuilder($connection): QueryBuilder
    {
        return new QueryBuilder($connection);
    }

    public static function with($relations)
    {
        return static::query()->with(
            is_string($relations) ? func_get_args() : $relations
        );
    }

    public static function all($columns = ['*']): bool|object|array
    {
        return static::query()->getFromDatabase(is_array($columns) ? $columns : func_get_args());
    }

    public function newInstance($attributes = [], $exists = false): static
    {
        $model = new static($attributes);
        $model->exists = $exists;

        $model->setTable($this->getTable());

        return $model;
    }

    public function newFormBuilder($attributes = []): static
    {
//        dump($attributes);
        $model = $this->newInstance([], true);
        $model->fill($attributes);
        return $model;
    }

    public function getForeignKey(): string
    {
        return $this->snake(class_basename($this)) . '_' . $this->getKeyName();
    }


    public function getKeyName(): string
    {
        return $this->primaryKey;
    }

    public function setTable($table): static
    {
        $this->table = $table;

        return $this;
    }

    public function getTable(): string
    {
        return $this->table??Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function getArrayableRelations(): array
    {
        return $this->relations;
    }

    #[Pure] public function attributeArray(): array
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

    #[Pure] public function toArray(): array
    {
        return array_merge($this->attributeArray(), $this->getArrayableRelations());
    }

    #[Pure] public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function __callStatic($method, $parameters): mixed
    {
        return (new static)->$method(...$parameters);
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters): mixed
    {
        if (in_array($method, ['increment', 'decrement'])) {
            return $this->$method(...$parameters);
        }
        // $this->newQuery() - Tạo một query mới.
        return $this->forwardCallTo($this->newQuery(), $method, $parameters);
    }

}
