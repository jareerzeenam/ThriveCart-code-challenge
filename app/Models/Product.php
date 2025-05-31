<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
        return [
            new self('R01', 'Red Widget', 32.95),
            new self('G01', 'Green Widget', 24.95),
            new self('B01', 'Blue Widget', 7.95),
        ];
    }
}
