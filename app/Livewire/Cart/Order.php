<?php

namespace App\Livewire\Cart;

use App\Models\Member;
use App\Models\OrderProduct;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Order extends Component
{
    public $search = '';
    public $product;
    public $order;
    public $total_price;
    public $total_qty;
    public $ppn; 
    public $grand_total;

    public $discount_code = '';
    public $discount_total;
    public $discount_price;

    // member
    public $phone_member;
    public $name_member;

    use WithPagination;

    public function render()
    {
        $this->order = \App\Models\Order::where('done_at', null) 
                ->with('orderProducts')
                ->latest()
                ->first();
        $this->total_price = $this->order->total_price ?? 0;
        $this->total_qty = $this->order->total_qty ?? 0;
        $this->ppn = ceil($this->total_price * 0.05);

        $this->discount_price = $this->discount();


        if($this->discount_code != '')
        {
            $this->grand_total = $this->total_price + $this->ppn - $this->discount_price;
        } else {
            $this->grand_total = $this->total_price + $this->ppn;
        }       

        $member = Member::all();

        $results = [];
        if(strlen($this->phone_member) > 0) {
            $results = Member::where('phone', 'like', '%'.$this->phone_member.'%')->get();
        }

        return view('livewire.cart.order', [
            'products' => Product::paginate(10),
            'order' => $this->order,
            'results' => $results,
        ]);
    }

    public function discount()
    {
        $discount_code = $this->discount_code;

        if($discount_code === 'FAIRUS123') 
        {
            $this->discount_total = '10%';
            $this->discount_price = $this->order->total_price * 0.1;
        }
        return $this->discount_price;
    }

    public function member()
    {
        $member = Member::where('phone', $this->phone_member)->first();

        if ($member == null) {
            $member = Member::firstOrCreate([
                'phone' => $this->phone_member,
            ]);

            $order = \App\Models\Order::where('done_at', null)
                    ->latest()
                    ->first();

            if ($order) {
                $order->update([
                    'member_id' => $member->id
                ]);
            }

            session()->flash('message', 'Member baru berhasil dibuat');
        } else {
            $order = \App\Models\Order::where('done_at', null)
                    ->latest()
                    ->first();

            if ($order) {
                $order->update([
                    'member_id' => $member->id
                ]);
            }
            $this->name_member = $member->name; 
            session()->flash('message', 'Nama Member: ' . $this->name_member);
        }

    }

    public function confirmOrder()
    {
        $discount_total = $this->discount_total ?? 0;
        $discount_price = $this->discount_price ?? 0;
        $grand_total = $this->grand_total;
        
        $order = \App\Models\Order::where('done_at', null)->latest()
        ->first();  

        if($order->member_id == null){
            session()->flash('error', 'member harus diisi!');
            return;
        }
        
        $order->update([
            'discount_type' => $discount_total,
            'discount_price' => $discount_price,
            'grand_total' => $grand_total,
        ]);

      

        $this->redirect('/payment');                
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

        $product = Product::where('id', $this->search)
        ->orWhere('product_name', 'like', '%' . $this->search . '%')
        ->first();
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
                    'unit_price' => $product->selling_price,
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
                            'unit_price' => $product->selling_price,
                            'quantity' => 1
                        ]);
                    }
                }
                $this->total_price = $this->order->total_price ?? 0;
            } 
        } catch(ValidationException $e) {
            dd($e);
        } catch(\Exception $e) {
            dd($e);
        }
    }

    function removeCart($id){
        $orderProduct = OrderProduct::where('order_id', $this->order->id)
                    ->where('product_id', $id)
                    ->first();
        $product = OrderProduct::all();
        if($product->count() > 1){
            $orderProduct->delete();
        } else {
            return false;
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
