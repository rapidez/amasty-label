<?php

namespace Rapidez\AmastyLabel\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WithAmastyCategoryLabelsScope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with('category_amasty_labels');
    }
}
