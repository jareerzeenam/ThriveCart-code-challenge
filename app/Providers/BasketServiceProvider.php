<?php

namespace App\Providers;

use App\Models\DeliveryChargeRule;
use App\Models\Offer;
use App\Models\Product;
use App\Services\BasketService;
use App\Services\OfferCalculator;
use Illuminate\Support\ServiceProvider;

class BasketServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(BasketService::class, function () {
        return new BasketService(
            Product::defaultCatalog(),
            DeliveryChargeRule::defaultRules(),
            Offer::defaultOffers(),
            new OfferCalculator()
        );
    });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
