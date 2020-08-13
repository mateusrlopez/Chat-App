<?php

namespace App\Filters;

use Illuminate\Support\Str;

abstract class BaseFilter
{
    public function handle($request, \Closure $next)
    {
        return $next($request)->when(request()->has($this->getFilterParam()), $this->applyFilter($next($request)));
    }

    protected function getFilterParam()
    {
        return Str::of(class_basename($this))->replace('Filter', '')->snake()->__toString();
    }

    abstract protected function applyFilter($builder);
} 