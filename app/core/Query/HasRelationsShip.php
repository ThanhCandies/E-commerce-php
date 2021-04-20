<?php


namespace App\core\Query;


trait HasRelationsShip
{
    public function belongsTo($related, $foreignKey = null, $ownerKey = null, $relation = null)
    {
        if(is_null($relation)){
            $relation=$this->guessBelongToRelation();
        }
        $foreignKey = $foreignKey?:$this->getForeignKey();
        return $relation;
//        $local
    }
    public function hasMany($related,$foreignKey = null,$localKey=null){
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey?:$this->getForeignKey();
        $localKey=$localKey?:$this->getKeyName();

    }

    public function guessBelongToRelation()
    {
        $one = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        return $one;
    }
    public function newRelatedInstance($related){
        return new $related;
    }

}