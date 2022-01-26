<?php

namespace App\Models\Scopes;

use App\Models\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AcademicYearScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (\request()->hasHeader('IsApi')) {
            $builder->whereBetween(
                'created_at',
                \get_academic_year(\today(), School::findOrFail(\request()->school_id))
            );
        } elseif (\request()->hasHeader('UniqueIdentity')) {
        } else {
            $builder->whereBetween('created_at', working_year());
        }
    }
}
