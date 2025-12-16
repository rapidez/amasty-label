<?php

namespace Rapidez\AmastyLabel\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Rapidez\Core\Models\Model;

class AmastyLabel extends Model
{
    protected $table = 'amasty_label_index';

    protected $variableRegex = '/(?<={)[a-zA-Z0-9_:]+(?=})/';

    protected $verticalPositions = ['top', 'middle', 'bottom'];
    protected $horizontalPositions = ['left', 'center', 'right'];

    protected static function booted(): void
    {
        static::addGlobalScope('amasty_label_data', function (Builder $builder) {
            $builder
                ->leftJoin('amasty_label_entity', function ($join) {
                    $join->on('amasty_label_entity.label_id', '=', 'amasty_label_index.label_id')
                         ->where('amasty_label_entity.status', 1);
                })
                ->leftJoin('amasty_label_catalog_parts', function ($join) {
                    $join->on('amasty_label_catalog_parts.label_id', '=', 'amasty_label_index.label_id');
                })
                ->where('store_id', config('rapidez.store'));
        });
    }

    protected function position(): Attribute
    {
        return Attribute::get(function ($position) {
            if (!is_int($position)) {
                return $position;
            }

            $horizontalPosition = $position % 3;
            $verticalPosition = $position - $horizontalPosition;

            return $this->verticalPositions[$verticalPosition].'-'.$this->horizontalPositions[$horizontalPosition];
        });
    }

    // TODO: replace variables in label_text with prices
    // - Where will we get the product price from? Retrieve a new product model?
    // - How do we want to do that with customer-specific pricing? Especially in the product listings.
}
