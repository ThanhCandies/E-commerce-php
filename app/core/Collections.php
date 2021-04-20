<?php


namespace App\core;


use Doctrine\Inflector\InflectorFactory;
use JetBrains\PhpStorm\Pure;

class Collections implements \JsonSerializable
{
    protected array $items = [];
    protected string $query = '';

    public function __construct(array $items = [], string $sql = '')
    {
        $this->items = $items;
        $this->query = $sql;
    }

    public function first()
    {
        foreach ($this->items as $item) {
            return $item;
        }
        return null;
    }

    public function all(): array
    {
        return $this->items;
    }

//    public function load($relations)
//    {
//        if ($this->isNotEmpty()) {
//            if (is_string($relations)) {
//                $relations = func_get_args();
//            }
////            $query = $this->first()->newQueryWithoutRelationships()->with($relations);
////
////            $this->items = $query->eagerLoadRelations($this->items);
//        }
//        return $this;
//    }

    public function getColumns(string|null $column = null): array
    {
        /**
         * @param $product Model
         */
        return array_filter(array_map(fn($product) => $product->getAttribute($column
            ?? $product->getKeyName()), $this->all()));
    }

    public function hasOne(object $models, $localKey, $foreignKey, $name = null): static
    {
        /**
         * @var Model $item
         * @var static $models
         */

        // [1,1,1,2,3,3,2,2]
        // [1,2,3]
//        $itemsId = $this->getColumns($localKey);
        $modelsKey = $models->getColumns($foreignKey);


        foreach ($this->all() as $item) {
            $pos = array_search($item->getAttribute($localKey), $modelsKey);
            if ($pos!==false) {
                $model = $models->all()[$pos];
                $item->setRelation($name??$model->getTable(),$model);
            }
        }

        return $this;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    #[Pure] public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function map(callable $callback)
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    #[Pure] public function jsonSerialize(): array
    {
//        dump($this->attributes);
        return $this->items;
    }
}