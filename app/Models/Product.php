<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product
{
    public string $code;
    public string $name;
    public float $price;

    public function __construct(string $code, string $name, float $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    public static function defaultCatalog(): array
    {
        return collect(config('products'))
            ->map(fn($product) => new self(
                $product['code'],
                $product['name'],
                $product['price']
            ))
            ->toArray();
    }
}
