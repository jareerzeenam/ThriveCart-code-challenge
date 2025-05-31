<?php

namespace App\Contracts;

interface OfferStrategy
{
    public function calculateDiscount(array $items): float;
}
