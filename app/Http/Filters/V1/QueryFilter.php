<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;

    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function filter($arr)
    {
        foreach($arr as $filter => $value)
        {
            if(method_exists($this, $filter))
            {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach($this->request->all() as $filter => $value)
        {
            if(method_exists($this, $filter))
            {
                $this->$filter($value);
            }
        }
        return $this->builder;
    }
}
