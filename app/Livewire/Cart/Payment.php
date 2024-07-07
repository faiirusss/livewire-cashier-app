<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use Livewire\Component;

class Payment extends Component

{
    public $order;
    public $paid_amount;
    public $return_amount;
    public $total_qty = 0;
    public $total_price = 0;
    public $ppn = 0;

    public $isModalOpen = false;

    public function render()
    {

        $this->order = Order::where('done_at', null)
                ->with('orderProducts')
                ->latest()
                ->first();

        $this->total_qty = 0;
        $this->total_price = 0;
        foreach ($this->order->orderProducts as $itemProduct) {
            $this->total_qty += $itemProduct->quantity;
            $this->total_price += $itemProduct->unit_price * $itemProduct->quantity;
        }
        $this->ppn = ceil($this->total_price * 0.05);
        
        return view('livewire.cart.payment', [
            'order' => $this->order,
            // 'orderProduct' => $orderProduct
        ]);
    }    

    public function payment()
    {
        $this->validate([
            'paid_amount' => 'required|numeric',
        ]);

        $this->total_qty = 0;
        $this->total_price = 0;
        foreach ($this->order->orderProducts as $itemProduct) {
            $this->total_qty += $itemProduct->quantity;
            $this->total_price += $itemProduct->unit_price * $itemProduct->quantity;
        }

        $this->return_amount = $this->paid_amount - $this->order->grand_total;

        if($this->paid_amount > $this->order->grand_total) {
            
            $this->order->update([
                'paid_amount' => $this->paid_amount,
                'return_amount' => $this->return_amount,
                'payment_method' => 'Cash',
            ]);
            $this->isModalOpen = true; 
            
        } else {
            $this->isModalOpen = true;
            $this->reset('paid_amount');
            session()->flash('error_payment', 'Uang yang dibayar kurang!');
        }
        
    }

    public function done()
    {       
        $this->order = Order::where('done_at', null)
        ->with('orderProducts')
        ->latest()
        ->first();       

        $this->order->update([
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
