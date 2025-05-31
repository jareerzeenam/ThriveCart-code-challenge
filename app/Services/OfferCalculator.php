<?php
namespace App\Services;

use App\Models\Offer;

class OfferCalculator
{
    public function calculateDiscount(array $items, Offer $offer): float
    {
        $filteredItems = array_values(array_filter($items, function ($item) use ($offer) {
            return $item->code === $offer->productCode;
        }));

        if (count($filteredItems) === 0) {
            return 0.0;
        }

        $productPrice = $filteredItems[0]->price;
        $count = count($filteredItems);

        if ($offer->type === 'half_price' && $count >= $offer->threshold) {
            $discountCount = floor($count / $offer->threshold);
            return round($productPrice * $offer->discountValue * $discountCount, 2);
        }

        return 0.0;
    }
}
