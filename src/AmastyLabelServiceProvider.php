<?php

namespace Rapidez\AmastyLabel;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\ServiceProvider;
use Rapidez\AmastyLabel\Models\AmastyLabel;
use Rapidez\AmastyLabel\Models\Scopes\WithAmastyCategoryLabelsScope;
use Rapidez\AmastyLabel\Models\Scopes\WithAmastyProductLabelsScope;
use Rapidez\Core\Models\Model;
use TorMorten\Eventy\Facades\Eventy;

class AmastyLabelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootViews()
            ->bootEventyFilters();
    }

    public function bootEventyFilters(): self
    {
        config('rapidez.models.product')::resolveRelationUsing('category_amasty_labels', function (Model $product): HasMany {
            return $product
                ->hasMany(AmastyLabel::class, 'product_id', 'entity_id')
                ->where('amasty_label_catalog_parts.type', 1);
        });

        config('rapidez.models.product')::resolveRelationUsing('product_amasty_labels', function (Model $product): HasMany {
            return $product
                ->hasMany(AmastyLabel::class, 'product_id', 'entity_id')
                ->where('amasty_label_catalog_parts.type', 2);
        });

        Eventy::addFilter('productpage.scopes', fn ($scopes) => array_merge($scopes ?: [], [WithAmastyProductLabelsScope::class]));
        Eventy::addFilter('index.product.scopes', fn ($scopes) => array_merge($scopes ?: [], [WithAmastyCategoryLabelsScope::class]));

        Eventy::addFilter('index.product.mapping', fn ($mapping) => array_merge_recursive($mapping ?: [], [
            'properties' => [
                'category_amasty_labels' => [
                    'type' => 'flattened',
                ],
                'product_amasty_labels' => [
                    'type' => 'flattened',
                ],
            ],
        ]));

        return $this;
    }

    public function bootViews(): self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'amastylabel');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/amastylabel'),
        ], 'views');

        return $this;
    }
}
