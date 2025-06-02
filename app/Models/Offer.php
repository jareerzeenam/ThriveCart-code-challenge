<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer
{
    public string $productCode;
    public string $type;
    public int $threshold;
    public float $discountValue;

    public function __construct(
        string $productCode,
        string $type,
        int $threshold,
        float $discountValue
    ) {
        $this->productCode = $productCode;
        $this->type = $type;
        $this->threshold = $threshold;
        $this->discountValue = $discountValue;
    }

    public static function defaultOffers(): array
    {
        return collect(config('offers'))
            ->map(fn($offer) => new self(
                $offer['productCode'],
                $offer['type'],
                $offer['threshold'],
                $offer['discountValue']
            ))
            ->toArray();
    }
}
