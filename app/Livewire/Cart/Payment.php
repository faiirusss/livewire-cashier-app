<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use Livewire\Component;

class Payment extends Component

{
    public $order;
    public $paid_amount;

    public function render()
    {

        $this->order = Order::where('done_at', null)
                ->with('orderProducts')
                ->latest()
                ->first();

        $orderProduct = $this->order->orderProducts->all();
        
        return view('livewire.cart.payment', [
            'order' => $this->order,
            'orderProduct' => $orderProduct
        ]);

    }

    public function payment_method($payment_method)
    {       
        $this->order->update([

            'payment_method' => $payment_method
        ]);

        return redirect()->route('payment');


    }

    public function done()
    {
        $this->validate([
            'paid_amount' => 'required'
        ]);

        $this->order->update([
            'paid_amount' => $this->paid_amount,
            'done_at' => now()
        ]);
        return redirect()->route('order');
    }
}
