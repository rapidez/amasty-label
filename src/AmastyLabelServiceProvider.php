<?php

namespace Rapidez\AmastyLabel;

use Illuminate\Support\ServiceProvider;
use Rapidez\AmastyLabel\Models\Scopes\WithProductAmastyLabelScope;
use TorMorten\Eventy\Facades\Eventy;

class AmastyLabelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'amastylabel');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez/amasty-label'),
        ], 'views');

        Eventy::addFilter('product.scopes', fn ($scopes) => array_merge($scopes ?: [], [WithProductAmastyLabelScope::class]));
        Eventy::addFilter('product.casts', fn ($casts) => array_merge($casts ?: [], ['amasty_label' => 'object']));
        Eventy::addFilter('index.product.mapping', fn ($mapping) => array_merge_recursive($mapping ?: [], [
            'properties' => [
                'amasty_label' => [
                    'type' => 'flattened',
                ],
            ],
        ]));
    }
}
