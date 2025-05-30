<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public $productCode;
    public $type;
    public $threshold;
    public $discount;

    public function __construct($productCode, $type, $threshold, $discount)
    {
        $this->productCode = $productCode;
        $this->type = $type;
        $this->threshold = $threshold;
        $this->discount = $discount;
    }

    public static function defaultOffers()
    {
        return [
            new self('R01', 'half_price', 2, 0.5),
        ];
    }
}
