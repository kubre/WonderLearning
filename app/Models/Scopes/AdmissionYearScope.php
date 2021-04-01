<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AdmissionYearScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $model->admission()->whereBetween('created_at', working_year());
    }
}
