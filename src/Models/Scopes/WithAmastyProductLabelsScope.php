<?php

namespace Rapidez\AmastyLabel\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WithAmastyProductLabelsScope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with('product_amasty_labels');
    }
}
