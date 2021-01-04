<?php

namespace RankFoundry\FulfillTile\Services;

use GuzzleHttp\Client;

class Fulfillment
{
    private static $base_url = 'https://api.sellbrite.com/v1/';
    
    
    public static function getFulfillments(string $api_token, string $api_key, string $warehouse): array
    {
        
        $client = new Client();
        $response = $client->request('GET', self::$base_url.'warehouses/fulfillments/'.$warehouse, [
            'auth' => [
                $api_token,
                $api_key
            ],
            'query' => [
                'sb_payment_status' => 'all'
            ]
        ]);
        
        $orders = json_decode($response->getBody()->getContents());
        $products = array();
        
        if(count($orders) > 0){
            foreach ($orders as $order){
                foreach($order->items as $item){
                    if(array_key_exists($item->sku,$products)){
                        $products[$item->sku]['qty'] = $products[$item->sku]['qty'] + $item->quantity;
                    }else{
                        $products[$item->sku] = array(
                            'title' => substr($item->title,0,25),
                            'sku' => $item->inventory_sku,
                            'bin' => self::getBinLocation($item->inventory_sku,$warehouse,$api_token,$api_key),
                            'qty' => $item->quantity,
                            'image' => self::getPrimaryImage($item->inventory_sku,$api_token,$api_key)
                        );
                    }
                }
            }
        }
        

        return $products;
    }
    
    public static function getBinLocation(string $sku, string $warehouse, string $api_token, string $api_key)
    {
        $client = new Client();        
        $response = $client->request('GET', self::$base_url.'inventory', [
            'auth' => [
                $api_token,
                $api_key
            ],
            'query' => [
                'warehouse_uuid' => $warehouse,
                'sku' => $sku
            ]
        ]);
        
        $obj = json_decode($response->getBody()->getContents());
        
        return $obj[0]->bin_location;
    }
    
    public static function getPrimaryImage(string $sku, string $api_token, string $api_key)
    {
        $client = new Client();        
        $response = $client->request('GET', self::$base_url.'products/'.$sku, [
            'auth' => [
                $api_token,
                $api_key
            ]
        ]);
        
        $obj = json_decode($response->getBody()->getContents(),true);
        
        $images = explode('|',$obj['image_list']);
        
        return $images[0];
    }
}

