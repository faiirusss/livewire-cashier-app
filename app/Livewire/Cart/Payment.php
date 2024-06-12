<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use Livewire\Component;

class Payment extends Component

{
    public $order;
    public $paid_amount;
    public $return_amount;
    public $total_qty;
    public $total_price;

    public function render()
    {

        $this->order = Order::where('done_at', null)
                ->with('orderProducts')
                ->latest()
                ->first();

        $orderProduct = $this->order->orderProducts->all();

        $grand_total = $this->order->grand_total;
        $this->return_amount = $this->paid_amount - $grand_total;
        
        foreach ($orderProduct as $itemProduct) {
           $this->total_qty += $itemProduct->quantity;
           $this->total_price += $itemProduct->unit_price * $itemProduct->quantity;

        }
        
        return view('livewire.cart.payment', [
            'order' => $this->order,
            'orderProduct' => $orderProduct
        ]);

    }    

    public function payment()
    {
        $this->order = Order::where('done_at', null)
        ->with('orderProducts')
        ->latest()
        ->first();

        $grand_total = $this->order->grand_total;
        $this->return_amount = $this->paid_amount - $grand_total;
        $this->refresh();
    }

    public function done()
    {       
        $this->order = Order::where('done_at', null)
        ->with('orderProducts')
        ->latest()
        ->first();

        $grand_total = $this->order->grand_total;
        $this->return_amount = $this->paid_amount - $grand_total;
        dd($this->return_amount);

        $this->validate([
            'paid_amount' => 'required',
            'return_amount' => 'required'
        ]);


        $this->order->update([
            'paid_amount' => $this->paid_amount,
            'return_amount' => $this->return_amount,
            'done_at' => now()
        ]);
        return redirect()->route('order');
    }

    public function pay_qris()
    {
        $this->order = Order::where('done_at', null)
        ->with('orderProducts')
        ->latest()
        ->first();

        $paid_amount = $this->order->grand_total;        

        $this->order->update([
            'paid_amount' => $paid_amount,
            'payment_method' => 'Qris',            
            'done_at' => now()
        ]);
        return redirect()->route('order');
    }
}
