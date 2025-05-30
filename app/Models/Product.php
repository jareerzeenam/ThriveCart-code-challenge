<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['code', 'name', 'price'];

    public static function defaultCatalog()
    {
        return [
            new self(['code' => 'R01', 'name' => 'Red Widget', 'price' => 32.95]),
            new self(['code' => 'G01', 'name' => 'Green Widget', 'price' => 24.95]),
            new self(['code' => 'B01', 'name' => 'Blue Widget', 'price' => 7.95]),
        ];
    }
}
