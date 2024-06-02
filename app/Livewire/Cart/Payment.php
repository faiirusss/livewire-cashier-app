<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use Livewire\Component;

class Payment extends Component
{
    public function render()
    {

        $order = Order::where('done_at', null)
                ->with('orderProducts')
                ->latest()
                ->first();

        $orderProduct = $order->orderProducts->all();
        
        return view('livewire.cart.payment', [
            'order' => $order,
            'orderProduct' => $orderProduct
        ]);

    }
}
