<?php

namespace Tests\Feature;

use App\Models\DeliveryChargeRule;
use App\Models\Offer;
use App\Models\Product;
use App\Services\BasketService;
use App\Services\OfferCalculator;
use Tests\TestCase;

class BasketServiceTest extends TestCase
{
    // private function createBasketService(): BasketService
    // {
    //     $products = Product::defaultCatalog();
    //     $deliveryRules = DeliveryChargeRule::defaultRules();
    //     $offers = Offer::defaultOffers();

    //     return new BasketService($products, $deliveryRules, $offers);
    // }

    private function getSubtotal(BasketService $basket): float
    {
        $reflection = new \ReflectionClass($basket);
        $method = $reflection->getMethod('calculateSubtotal');
        $method->setAccessible(true);

        return $method->invoke($basket);
    }

    private function getDeliveryCost(float $amount, array $rules): float
    {
        foreach ($rules as $rule) {
            if ($amount >= $rule->minAmount && $amount < $rule->maxAmount) {
                return $rule->cost;
            }
        }
        return 0;
    }

    public function test_add_product_to_basket()
    {
        $basket = app(BasketService::class);
        $basket->add('R01');

        $this->assertCount(1, $basket->getBasket());
        $this->assertEquals('R01', $basket->getBasket()[0]->code);
    }


    public function test_calculates_correct_total_for_B01_G01()
    {
        $basket = app(BasketService::class);
        $basket->add('B01');
        $basket->add('G01');

        $this->assertEquals(37.85, $basket->total());
    }
    public function test_calculates_correct_total_for_R01_R01()
    {
        $basket = app(BasketService::class);
        $basket->add('R01');
        $basket->add('R01');

        $this->assertEqualsWithDelta(54.37, $basket->total(), 0.01);
    }
    public function test_calculates_correct_total_for_R01_G01()
    {
        $basket = app(BasketService::class);
        $basket->add('R01');
        $basket->add('G01');

        $this->assertEquals(60.85, $basket->total());
    }


    public function test_calculates_free_delivery_correctly()
    {
        $basket = app(BasketService::class);
        $basket->add('B01');
        $basket->add('B01');
        $basket->add('R01');
        $basket->add('R01');
        $basket->add('R01');

        $subtotal = $this->getSubtotal($basket);

        $this->assertGreaterThanOrEqual(90, $subtotal);
        $this->assertEqualsWithDelta(98.27, $basket->total(), 0.01);
    }

    public function test_delivery_charges()
    {
        $rules = DeliveryChargeRule::defaultRules();

        $this->assertEquals(4.95, $this->getDeliveryCost(49.99, $rules));

        $this->assertEquals(2.95, $this->getDeliveryCost(50, $rules));
        $this->assertEquals(2.95, $this->getDeliveryCost(89.99, $rules));

        $this->assertEquals(0, $this->getDeliveryCost(90, $rules));
        $this->assertEquals(0, $this->getDeliveryCost(150, $rules));
    }


    public function test_throws_exception_for_invalid_product_code()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->expectExceptionMessage('Product with code INVALID not found');
        $basket = app(BasketService::class);
        $basket->add('INVALID');
    }
}
