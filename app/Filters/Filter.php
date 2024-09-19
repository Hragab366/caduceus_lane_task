<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

abstract class Filter
{
    protected Builder $query ;
    protected array $filters=[];
    protected array $verified_methods=[];


    /**
     * @throws \Exception
     */
    public function apply(Builder $query):Builder
    {
        $this->query = $query;
        foreach ($this->filters as $filter) {
            if (
                $this->isFilterReceived($filter)&&
                $this->isFilterVerified($filter)&&
                method_exists($this, $filter)
            ) {
                $this->$filter();
            }
        }
        return $query;
    }
    private function isFilterReceived($filter):bool{
        return request()->has($filter);
    }
    private function isFilterVerified($filter): bool
    {
        if (!in_array($filter, $this->verified_methods)) {
            throw new \Exception("You must verify the '{$filter}' method");
        }
        return true;
    }
    public function  validateInput(array $rules){
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }

}
