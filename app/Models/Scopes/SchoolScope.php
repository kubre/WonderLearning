<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SchoolScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        if (!$user->hasAccess('admin.school')) {
            $builder->where('school_id', $user->school_id);
        }
    }
}
