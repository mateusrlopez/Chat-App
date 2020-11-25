<?php

namespace App\Filters;

class WithoutUserFilter extends BaseFilter
{
    protected function applyFilter($builder)
    {
        return fn($builder) => $builder->whereDoesntHave('users', fn($subQuery) => $subQuery->whereId(request($this->getFilterParam())));
    }
}