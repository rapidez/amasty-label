<?php

namespace Rapidez\AmastyLabel\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WithAmastyProductLabelsScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with('product_amasty_labels');
    }
}
