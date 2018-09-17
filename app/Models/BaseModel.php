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
        $validate = validator(['with', 'scope'], [
            'with' => 'string',
            'scope' => 'string'
        ]);

        if(is_null($target = $model)) {
            $target = $this;
        }

        if($validate->fails()) {
            return $target;
        }

        $data = request(['with', 'scope']);

        if(! is_null($with = array_get($data, 'with'))) {
            $target = $target->with(explode(',', $with));
        }

        if(! is_null($scopes = array_get($data, 'scope'))) {
            foreach (explode(',', $scopes) as $scope) {
                $datas = explode(':', $scope);

                $query = array_get($datas, 0);
                $value = array_get($datas, 1);

                $target = !is_null($value) ? $target->$query($value) : $target->$query;
            }
        }

        return $target;
    }
}