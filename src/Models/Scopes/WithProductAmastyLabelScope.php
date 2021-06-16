<?php

namespace Rapidez\AmastyLabel\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class WithProductAmastyLabelScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $newVersion = Cache::rememberForever('amasty.label.version', function () {
            return Schema::hasTable('amasty_label_catalog_parts');
        });

        if ($newVersion) {
            $builder
                ->selectRaw('JSON_REMOVE(JSON_OBJECTAGG(IFNULL(amasty_label_index.label_id, "null__"), JSON_OBJECT(
                    "prod_txt", prod.label_text,
                    "prod_style", prod.style,
                    "cat_txt", cat.label_text,
                    "cat_style", cat.style,
                    "priority", priority,
                    "is_single", is_single
                )), "$.null__") as amasty_label')
                ->leftJoin('amasty_label_index', function ($join) use ($model) {
                    $join->on('amasty_label_index.product_id', '=', $model->getTable() . '.entity_id')
                         ->where('amasty_label_index.store_id', config('rapidez.store'));
                })
                ->leftJoin('amasty_label_entity', function ($join) {
                    $join->on('amasty_label_entity.label_id', '=', 'amasty_label_index.label_id')
                         ->where('status', 1);
                })
                ->leftJoin('amasty_label_catalog_parts as cat', function ($join) {
                    $join->on('cat.label_id', '=', 'amasty_label_index.label_id')
                        ->where('cat.type', '1');
                })->leftJoin('amasty_label_catalog_parts as prod', function ($join) {
                    $join->on('prod.label_id', '=', 'amasty_label_index.label_id')
                        ->where('prod.type', '2');
                });
            return;
        }

        $builder
            ->selectRaw('JSON_REMOVE(JSON_OBJECTAGG(IFNULL(am_label.label_id, "null__"), JSON_OBJECT(
                "prod_txt", prod_txt,
                "prod_style", prod_style,
                "cat_txt", cat_txt,
                "cat_style", cat_style,
                "priority", pos,
                "is_single", is_single
            )), "$.null__") as amasty_label')
            ->leftJoin('amasty_label_index', function ($join) use ($model) {
                $join->on('amasty_label_index.product_id', '=', $model->getTable() . '.entity_id')
                     ->where('amasty_label_index.store_id', config('rapidez.store'));
            })
            ->leftJoin('am_label', function ($join) {
                $join->on('am_label.label_id', '=', 'amasty_label_index.label_id')
                     ->where('status', 1);
            });
    }
}
