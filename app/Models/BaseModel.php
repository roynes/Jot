<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * Applies a relation that was present from the query params
     *
     * @param BaseModel|null $model
     * @return BaseModel|Model
     */
    public function applyQueryParamRelation (BaseModel $model = null)
    {
        $validate = validator(['with'], [
            'with' => 'string'
        ]);

        if(is_null($target = $model)) {
            $target = $this;
        }

        if($validate->fails()) {
            return $target;
        }

        $data = request(['with']);

        if(! is_null($with = $data['with'])) {
            $target = $target->with($with);
        }

        return $target;
    }
}