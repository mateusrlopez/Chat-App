<?php

namespace App\Filters;

class WithoutMemberFilter extends BaseFilter
{
    protected function applyFilter($builder)
    {
        return fn($builder) => $builder->whereDoesntHave('users', fn($subQuery) => $subQuery->whereId(request($this->getFilterParam())));
    }
}