<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'invoice_number',
        'payment_method',
        'discount_type',
        'discount_price',
        'grand_total',
        'paid_amount',
        'return_amount',
        'done_at',  
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getTotalPriceAttribute()
    {
        $orderProducts = $this->orderProducts;
        $totalPrice = 0;

        foreach ($orderProducts as $orderProduct) {
            $totalPrice += $orderProduct->unit_price * $orderProduct->quantity;
        }
        
        return $totalPrice;
    }  

    public function getTotalQtyAttribute()
    {
        $orderProducts = $this->orderProducts;
        $totalQty = 0;

        foreach ($orderProducts as $orderProduct) {
            $totalQty += $orderProduct->quantity;
        }
        
        return $totalQty;
    }   

    

    public function getTotalPriceFormattedAttribute()
    {
        return 'Rp' . number_format($this->totalPrice, 0, ',', '.');
    }
    
    

}
