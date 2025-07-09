<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class QueryFilter
{
    protected $builder;

    protected $request;
    protected $sortable= [];
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

    protected function sort($value)
    {
        $sortAttributes = explode(',', $value);
        foreach($sortAttributes as $sortAttribute)
        {

            if(!in_array($sortAttribute, $this->sortable) ) continue;

            $direction = Str::startsWith($sortAttribute, '-') ? 'asc' : 'desc';

            $columnName = Str::of($sortAttribute)->remove('-')->snake()->value();

            $this->builder->orderBy($columnName, $direction);
        }

        return $this->builder;
    }
}
