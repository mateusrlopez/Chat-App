<?php

namespace App\Filters;

class PrivateFilter extends BaseFilter
{
    protected function applyFilter($builder)
    {
        return fn($builder) => $builder->where('private',  request($this->getFilterParam()));
    }
}