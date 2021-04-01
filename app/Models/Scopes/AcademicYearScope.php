<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AcademicYearScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereBetween('created_at', working_year());
    }
}