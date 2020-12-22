<?php

namespace App\Filters;

class OrderByFilter extends BaseFilter
{
    protected function applyFilter($builder)
    {
        return fn($builder) => $builder->orderBy($this->getFilterParam());
    }
}