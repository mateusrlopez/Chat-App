<?php

namespace App\Filters;

class FriendChannels extends BaseFilter
{
    protected function applyFilter($builder)
    {
        return fn($builder) => $builder->whereHas('user', fn($query) => $query->whereHas('friend', fn($subQuery) => $subQuery->whereId(request($this->getFilterParam())))->where('id', '<>', request($this->getFilterParam())));
    }
}