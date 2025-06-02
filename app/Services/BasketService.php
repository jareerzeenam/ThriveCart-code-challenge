<?php
namespace App\Services;

use App\Models\Product;
class BasketService
{
    private array $products;
    private array $deliveryRules;
    private array $offers;
    private array $items = [];
    private OfferCalculator $offerCalculator;

    public function __construct(
        array $products,
        array $deliveryRules,
        array $offers,
        OfferCalculator $offerCalculator
    ) {
        $this->products = $products;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
        $this->offerCalculator = $offerCalculator;
    }

    public function add($productCode): void
    {
        $product = $this->findProductByCode($productCode);

        if (!$product) {
            throw new \InvalidArgumentException("Product with code {$productCode} not found");
        }

        $this->items[] = $product;
    }

    public function getBasket(): array
    {
        return $this->items;
    }

    public function total(): float
    {
        $subtotal = $this->calculateSubtotal();
        $delivery = $this->calculateDelivery($subtotal);
        return round($subtotal + $delivery, 2);
    }

     protected function calculateSubtotal(): float
    {
        $subtotal = array_reduce(
            $this->items,
            fn(float $carry, Product $item) => $carry + $item->price,
            0.0
        );

        foreach ($this->offers as $offer) {
            $discount = $this->offerCalculator->calculateDiscount($this->items, $offer);
            $subtotal -= $discount;
        }

        return $subtotal;
    }


    protected function calculateDelivery($subtotal)
    {
        foreach ($this->deliveryRules as $rule) {
            if ($subtotal >= $rule->minAmount && $subtotal < $rule->maxAmount) {
                return $rule->cost;
            }
        }
        return 0.0;
    }

    protected function findProductByCode($code)
    {
        foreach ($this->products as $product) {
            if ($product->code === $code) {
                return $product;
            }
        }

        return null;
    }
}
