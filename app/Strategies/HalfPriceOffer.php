<?php
namespace App\Strategies;


use App\Contracts\OfferStrategy;

class HalfPriceOffer implements OfferStrategy
{
    private string $productCode;
    private int $threshold;
    private float $discount;

    public function __construct(string $productCode, int $threshold, float $discount)
    {
        $this->productCode = $productCode;
        $this->threshold = $threshold;
        $this->discount = $discount;
    }

    public function calculateDiscount(array $items): float
    {
        $applicableItems = array_filter($items, fn($item) => $item->code === $this->productCode);
        $count = count($applicableItems);

        if ($count < $this->threshold) {
            return 0.0;
        }

        $discountCount = floor($count / $this->threshold);
        $productPrice = $applicableItems[0]->price;

        $discount = $productPrice * $this->discount * $discountCount;

        return round($discount, 2);
    }
}
