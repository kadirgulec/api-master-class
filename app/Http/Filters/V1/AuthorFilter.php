<?php

namespace App\Http\Filters\V1;

class AuthorFilter extends QueryFilter
{
    protected $sortable = [
        'id',
        'name',
        'email',
        'createdAt',
        'updatedAt',
    ];

    public function include($value)
    {
        return $this->builder->with($value);
    }
    public function id($value)
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function email($value)
    {
        $title = str_replace('*', '%', $value);
        return $this->builder->where('email', 'like', $title);
    }

    public function name($value)
    {
        $title = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $title);
    }

    public function createdAt($value)
    {

        $dates = explode(',', $value);
        if (count($dates) === 2) {

            return $this->builder->whereBetween('created_at', $dates);

        }
        return $this->builder->whereDate('created_at', $value);
    }

    public function updatedAt($value)
    {
        $dates = explode(',', $value);
        if (count($dates) === 2) {
            return $this->builder->whereBetween('updated_at', $dates);
        }
        return $this->builder->whereDate('updated_at', $value);
    }
}
