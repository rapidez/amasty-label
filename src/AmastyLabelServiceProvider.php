<?php

namespace Rapidez\AmastyLabel;

use Illuminate\Support\ServiceProvider;
use Rapidez\AmastyLabel\Models\Scopes\WithProductAmastyLabelScope;
use Rapidez\AmastyLabel\Models\Casts\CastAmastyLabelVariables;
use TorMorten\Eventy\Facades\Eventy;

class AmastyLabelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootViews()
            ->bootEventyFilters();
    }

    public function bootEventyFilters() : self
    {
        Eventy::addFilter('product.scopes', fn ($scopes) => array_merge($scopes ?: [], [WithProductAmastyLabelScope::class]));
        Eventy::addFilter('product.casts', fn ($casts) => array_merge($casts ?: [], ['amasty_label' => CastAmastyLabelVariables::class]));
        Eventy::addFilter('index.product.mapping', fn ($mapping) => array_merge_recursive($mapping ?: [], [
            'properties' => [
                'amasty_label' => [
                    'type' => 'flattened',
                ],
            ],
        ]));

        return $this;
    }

    public function bootViews() : self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'amastylabel');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/amastylabel'),
        ], 'views');

        return $this;
    }
}
