<?php

namespace Rapidez\AmastyLabel\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WithProductAmastyLabelScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder
            ->selectRaw('JSON_REMOVE(JSON_OBJECTAGG(IFNULL(am_label.label_id, "null__"), JSON_OBJECT(
                "prod_txt", prod_txt,
                "prod_style", prod_style,
                "cat_txt", cat_txt,
                "cat_style", cat_style
            )), "$.null__") as amasty_label')
            ->leftJoin('amasty_label_index', function ($join) use ($model) {
                $join->on('amasty_label_index.product_id', '=', $model->getTable() . '.entity_id')
                     ->where('amasty_label_index.store_id', config('rapidez.store'));
            })
            ->leftJoin('am_label', 'am_label.label_id', '=', 'amasty_label_index.label_id');
    }
}
