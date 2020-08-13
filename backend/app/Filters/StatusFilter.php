<?php

namespace App\Filters;

class StatusFilter extends BaseFilter
{
    protected function applyFilter($builder)
    {
        return fn($builder) => $builder->when(request($this->getFilterParam()) === 'inviter', fn($subQuery) => $subQuery->whereInviterId(request()->route('user')->id), fn($subQuery) => $subQuery->whereInvitedId(request()->route('user')->id));
    }
}