<?php

namespace App\Filters;

class LimitFilter extends BaseFilter
{
    protected function applyFilter($builder)
    {
        return fn($builder) => $builder->limit($this->getFilterParam());
    }
}