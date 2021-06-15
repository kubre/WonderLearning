<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SchoolScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (\request()->is_api) {
            $builder->where('school_id', \request()->school_id);
        } else {
            $user = auth()->user();
            if (!$user->hasAccess('admin.school')) {
                $builder->where('school_id', $user->school_id);
            }
        }
    }
}
