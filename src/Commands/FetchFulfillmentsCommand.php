<?php

namespace RankFoundry\FulfillTile\Commands;

use RankFoundry\FulfillTile\FulfillStore;
use RankFoundry\FulfillTile\Services\Fulfillment;
use Illuminate\Console\Command;

class FetchFulfillmentsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'dashboard:fetch-fulfillments';

    /**
     * @var string
     */
    protected $description = 'Fetches items needing to be shipped';

    /**
     * @return int
     */
    public function handle()
    {
        $api_token = config('dashboard.tiles.fulfill.api_token');
        $api_key = config('dashboard.tiles.fulfill.api_key');
        $warehouse = config('dashboard.tiles.fulfill.warehouse');

        if (! $api_token) {
            $this->error('Fulfillment API Token is missing. Please configure!');

            return 1;
        }
        
        if (! $api_key) {
            $this->error('Fulfillment API Key is missing. Please configure!');

            return 1;
        }
        
        if (! $warehouse) {
            $this->error('Fulfillment Warehouse UUID is missing. Please configure!');

            return 1;
        }

        $response = Fulfillment::getFulfillments(
            $api_token, $api_key, $warehouse
        );

        if (isset($response['errors'])) {
            $this->error('Fulfillment API error: ' . $response['errors']);

            return 1;
        }

        FulfillStore::make()->setProducts($response ?? []);

        $this->info('All done!');

        return 0;
    }
}