<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryChargeRule
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

    public static function defaultRules(): array
    {
        return collect(config('delivery'))
            ->map(fn($rule) => new self(
                $rule['minAmount'],
                $rule['maxAmount'],
                $rule['cost']
            ))
            ->toArray();
    }
}
