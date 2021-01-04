<?php

namespace RankFoundry\FulfillTile;

use Livewire\Component;

class FulfillTileComponent extends Component
{
    public $position;


    public function mount(string $position)
    {
        $this->position = $position;
    }
    
    
    public function render()
    {
        return view('dashboard-fulfill-tile::tile', [
            'products' => FulfillStore::make()->products(),
            'refreshIntervalInSeconds' => config('dashboard.tiles.fulfill.refresh_interval_in_seconds') ?? 60,
        ]);
    }
}
