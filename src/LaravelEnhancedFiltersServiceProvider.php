<?php

namespace Alkhachatryan\LaravelEnhancedFilters;

use Illuminate\Support\ServiceProvider;

class LaravelEnhancedFiltersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(QueryBuilderEnhancedFilter::class, function ($app) {
            return new QueryBuilderEnhancedFilter();
        });
    }

    public function boot(): void
    {
    }
}
