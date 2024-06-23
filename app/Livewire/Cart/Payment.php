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

        // $orderProduct = $this->order->orderProducts->all();

        // $grand_total = $this->order->grand_total;
        // $this->return_amount = $this->paid_amount - $grand_total;
        
        // foreach ($orderProduct as $itemProduct) {
        //    $this->total_qty += $itemProduct->quantity;
        //    $this->total_price += $itemProduct->unit_price * $itemProduct->quantity;

        // }
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
            'paid_amount' => 'required|numeric|min:' . $this->order->grand_total, // Validasi agar paid_amount >= grand_total
        ]);

        // Perhitungan total_qty dan total_price
        $this->total_qty = 0;
        $this->total_price = 0;
        foreach ($this->order->orderProducts as $itemProduct) {
            $this->total_qty += $itemProduct->quantity;
            $this->total_price += $itemProduct->unit_price * $itemProduct->quantity;
        }

        // Perhitungan return_amount
        $this->return_amount = $this->paid_amount - $this->order->grand_total;

        // Update order dengan informasi pembayaran
        $this->order->update([
            'paid_amount' => $this->paid_amount,
            'return_amount' => $this->return_amount,
            'payment_method' => 'Cash',
        ]);
        
        $this->isModalOpen = true; // Modal tetap terbuka setelah pembayaran
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
