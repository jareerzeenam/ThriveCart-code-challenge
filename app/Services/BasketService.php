<?php
namespace App\Services;

class BasketService
{
    protected $products;
    protected $deliveryRules;
    protected $offers;
    protected $items = [];

    public function __construct($products, $deliveryRules, $offers)
    {
        $this->products = $products;
        $this->deliveryRules = $deliveryRules;
        $this->offers = $offers;
    }

    public function add($productCode)
    {
        $product = $this->findProductByCode($productCode);

        if (!$product) {
            throw new \InvalidArgumentException("Product with code {$productCode} not found");
        }

        $this->items[] = $product;
    }

    public function total()
    {
        $subtotal = $this->calculateSubtotal();
        $delivery = $this->calculateDelivery($subtotal);

        return round($subtotal + $delivery, 2);
    }

    protected function calculateSubtotal()
    {
        $subtotal = 0;
        $productCounts = [];

        foreach ($this->items as $item) {
            if (!isset($productCounts[$item->code])) {
                $productCounts[$item->code] = 0;
            }
            $productCounts[$item->code]++;
        }

        foreach ($this->offers as $offer) {
            if (isset($productCounts[$offer->productCode]) &&
                $productCounts[$offer->productCode] >= $offer->threshold) {

                $product = $this->findProductByCode($offer->productCode);
                $applicableItems = floor($productCounts[$offer->productCode] / $offer->threshold);

                if ($offer->type === 'half_price') {
                    $discount = $product->price * $offer->discount * $applicableItems;
                    $subtotal -= $discount;
                }
            }
        }

        foreach ($this->items as $item) {
            $subtotal += $item->price;
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

        return 0;
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
