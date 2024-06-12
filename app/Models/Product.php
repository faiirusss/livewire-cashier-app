<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'selling_price',
        'stock',
        'color',
        'image'
    ];

    public function getHargaFormattedAttribute()
    {
        return 'Rp  ' . number_format($this->selling_price, 0, ',', '.');
    }
}
