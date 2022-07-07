<?php

namespace Rapidez\AmastyLabel;

use Illuminate\Support\ServiceProvider;
use Rapidez\AmastyLabel\Models\Scopes\WithProductAmastyLabelScope;
use TorMorten\Eventy\Facades\Eventy;

class AmastyLabelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootViews()
            ->bootConfig()
            ->bootEventyFilters();
    }

    public function bootEventyFilters() : self
    {
        Eventy::addFilter('product.scopes', fn ($scopes) => array_merge($scopes ?: [], [WithProductAmastyLabelScope::class]));
        Eventy::addFilter('index.product.mapping', fn ($mapping) => array_merge_recursive($mapping ?: [], [
            'properties' => [
                'amasty_label' => [
                    'type' => 'flattened',
                ],
            ],
        ]));

        return $this;
    }

    public function bootConfig() : self
    {
        $this->mergeConfigFrom(__DIR__.'/../config/amasty-label.php', 'amastylabel');

        $this->publishes([
            __DIR__.'/../config/amasty-label.php' => config_path('amasty-label.php'),
        ], 'config');

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
