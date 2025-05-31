<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
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
        return [
            new self('R01', 'half_price', 2, 0.5),
        ];
    }
}
