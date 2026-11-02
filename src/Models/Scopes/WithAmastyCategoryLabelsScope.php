<?php

namespace Rapidez\AmastyLabel\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WithAmastyCategoryLabelsScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with('category_amasty_labels');
    }
}
