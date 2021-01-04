<?php

namespace RankFoundry\FulfillTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use RankFoundry\FulfillTile\Commands\FetchFulfillmentsCommand;

class FulfillTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('fulfill-tile', FulfillTileComponent::class);
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchFulfillmentsCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-fulfill-tile'),
        ], 'dashboard-fulfill-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-fulfill-tile');
    }
}
