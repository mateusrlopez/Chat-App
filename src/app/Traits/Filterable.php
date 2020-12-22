<?php

namespace App\Traits;

use Illuminate\Pipeline\Pipeline;

trait Filterable
{
    protected static function filterQuery()
    {
        return app(Pipeline::class)->send(self::query())->through(self::getFilters())->thenReturn();
    }

    abstract protected static function getFilters();
}