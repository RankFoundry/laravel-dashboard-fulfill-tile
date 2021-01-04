# A tile to display orders needing fulfillment from SellBrite

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rankfoundry/laravel-dashboard-fulfill-tile.svg?style=flat-square)](https://packagist.org/packages/rankfoundry/laravel-dashboard-fulfill-tile)
[![Total Downloads](https://img.shields.io/packagist/dt/rankfoundry/laravel-dashboard-fulfill-tile.svg?style=flat-square)](https://packagist.org/packages/rankfoundry/laravel-dashboard-fulfill-tile)



This tile can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard) to display orders ready for fulfillment in SellBrite.


## Installation

You can install the tile via composer:

```bash
composer require rankfoundry/laravel-dashboard-fulfill-tile.
```

Sign up to [SellBrite](https://bit.ly/2ZpJuyX) to manage your e-commerce sales from multiple marketplaces. 
Once your account is created you will need to obtain an API Token and API Key. You will also need your local warehouse UUID.

```php
// in config/dashboard.php

return [
    // ...
    'tiles' => [
        'fulfill' => [
            'api_token' => '#######################',
            'api_key' => '#######################',
            'warehouse' => '#######################',
        ],
    ],
];
```

In `app\Console\Kernel.php` you should schedule the `RankFoundry\FulfillTile\FetchFulfillmentsCommand` to run every five minutes. 

```php
// in app/console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // ...
    $schedule->command(\RankFoundry\FulfillTile\Commands\FetchFulfillmentsCommand::class)->everyFiveMinutes();
}
```

You are also able to execute the command manually.

```bash
php artisan dashboard:fetch-fulfillments
```

## Usage

In your dashboard view you use the `livewire:fulfill-tile` component.

```html
<x-dashboard>
    <livewire:fulfill-tile position="a1" />
</x-dashboard>
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@rankfoundry.com instead of using the issue tracker.

## Credits

- [Kevin Fairbanks](https://github.com/KevinFairbanks)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
