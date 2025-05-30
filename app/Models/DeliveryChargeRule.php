<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryChargeRule extends Model
{
    public $minAmount;
    public $maxAmount;
    public $cost;

     public function __construct($minAmount, $maxAmount, $cost)
    {
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
        $this->cost = $cost;
    }

    public static function defaultRules()
    {
        return [
            new self(0, 50, 4.95),
            new self(50, 90, 2.95),
            new self(90, PHP_FLOAT_MAX, 0),
        ];
    }
}
