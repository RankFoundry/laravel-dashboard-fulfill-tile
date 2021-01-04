<?php

namespace RankFoundry\FulfillTile;

use Spatie\Dashboard\Models\Tile;

class FulfillStore
{
    private Tile $tile;

    public static function make()
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName("fulfill");
    }
    
    /**
     * @return array
     */
    public function products(): array
    {
        return $this->tile->getData('products') ?? [];
    }

    /**
     * @param array $projects
     *
     * @return $this
     */
    public function setProducts(array $products): self
    {
        $this->tile->putData('products', $products);

        return $this;
    }

}
