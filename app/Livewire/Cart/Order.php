<?php

namespace App\Livewire\Cart;

use App\Models\OrderProduct;
use App\Models\Product;
use Livewire\Component;

class Order extends Component
{
    public $search = '';
    public $product;
    public $order;
    public $harga;

    public function render()
    {
        $this->order = \App\Models\Order::where('done_at', null) 
                ->with('orderProducts')
                ->latest()
                ->first();
        $this->harga = $this->order->harga ?? 0;
        return view('livewire.cart.order', [
            'products' => Product::paginate(10),
            'order' => $this->order
        ]);

    }

    public function createOrder($isAdded = true)
    {
        $this->order = \App\Models\Order::where('done_at', null)
                    ->latest()
                    ->first();        

        if($this->order == null)
        {
            $this->order = \App\Models\Order::create([
                'invoice_number' => $this->generateUniqueCode(),
            ]);
        }

        $product = Product::findOrFail($this->search);
        $orderProduct = OrderProduct::where('order_id', $this->order->id)
                    ->where('product_id', $this->search)
                    ->first();
        if($orderProduct)
        {
            if($isAdded)
            {
                $orderProduct->increment('quantity', 1);
            }
            else
            {
                $orderProduct->decrement('quantity', 1);
                if ($orderProduct->quantity < 1) {
                    $orderProduct->delete();
                }
            }
            $orderProduct->save();
        } else {
            if($isAdded)
            {
                OrderProduct::create([
                    'order_id' => $this->order->id,
                    'product_id' => $product->id,
                    'price' => $product->harga,
                    'quantity' => 1
                ]);
            }
        }

        $this->reset('search');
    }

    

    public function updateCart($isAdded = true, $id)
    {   
        // $product = Product::where('id', $this->search)->first();
        // dd($product);
        try {
            
            if($this->order)
            { 
                $product = Product::findOrFail($id);
                $orderProduct = OrderProduct::where('order_id', $this->order->id)
                    ->where('product_id', $id)
                    ->first();

                if($orderProduct)
                {
                    if($isAdded)
                    {
                        $orderProduct->increment('quantity', 1);
                    }
                    else
                    {
                        $orderProduct->decrement('quantity', 1);
                        if ($orderProduct->quantity < 1) {
                            $orderProduct->delete();
                        }
                    }
                    $orderProduct->save();
                } else {
                    if($isAdded)
                    {
                        OrderProduct::create([
                            'order_id' => $this->order->id,
                            'product_id' => $product->id,
                            'price' => $product->harga,
                            'quantity' => 1
                        ]);
                    }
                }
                $this->harga = $this->order->harga ?? 0;
            } 
        } catch(ValidationException $e) {
            dd($e);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    function generateUniqueCode($length = 6) {
        $number = uniqid();
        $varray = str_split($number);
        $len = sizeof($varray);
        $uniq = array_slice($varray, $len-6, $len);
        $uniq = implode(",", $uniq);
        $uniq = str_replace(',', '', $uniq);

        return $uniq;
    }


}
