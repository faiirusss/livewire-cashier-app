<?php

namespace App\Livewire\Cart;

use App\Models\Member;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
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
    public $discount_type;
    public $discount_price;

    // member
    public $phone_member;
    public $name_member;

    use WithPagination;

    public function render()
    {
        $this->order = \App\Models\Order::where('user_id', auth()->id()) // Tambahkan filter user_id
                ->where('done_at', null)
                ->with('orderProducts')
                ->latest()
                ->first();

        $this->total_price = $this->order->total_price ?? 0;
        $this->total_qty = $this->order->total_qty ?? 0;
        $this->ppn = ceil($this->total_price * 0.11);

        $this->discount_price = $this->discount();

        if($this->discount_code != '')
        {
            $this->grand_total = $this->total_price + $this->ppn - $this->discount_price;
        } else {
            $this->grand_total = $this->total_price + $this->ppn;
        }

        $results = [];
        if(strlen($this->phone_member) > 0) {
            $results = Member::where('phone', 'like', '%'.$this->phone_member.'%')->get();
        }

        return view('livewire.cart.order', [
            'products' => Product::paginate(10),
            'order' => $this->order,
            'members' => Member::all(),
            'results' => $results,
        ]);
    }

    public function createOrder($isAdded = true)
    {

        // mencari product dengan id
        $product = Product::where('sku', $this->search)
        ->orWhere('product_name', 'like', '%' . $this->search . '%')
        ->first();
        if($product)
        {
            if($product->stock >= 1)
            {
                $this->order = \App\Models\Order::where('user_id', auth()->id())
                ->where('done_at', null)
                ->latest()
                ->first();

                if ($this->order == null) {
                    $this->order = \App\Models\Order::create([
                        'invoice_number' => $this->generateUniqueCode(),
                        'user_id' => auth()->id(),
                    ]);
                    session(['id_order' => $this->order->id]);
                }

                // mencari product di order product
                $orderProduct = OrderProduct::where('order_id', $this->order->id)
                    ->where('sku_product', $this->search)
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
                            'sku_product' => $product->sku,
                            'unit_price' => $product->selling_price,
                            'quantity' => 1
                        ]);

                        $orderProductCount = $this->order->orderProducts->count();
                        if($orderProductCount == 1)
                        {
                            return redirect()->route('order');
                        }
                    }
                }
            }
            else {
                session()->flash('stock_error', 'Stok Barang Habis!');
                // dd('stok abis');
            }

        } else {
            session()->flash('product_error', 'Produk Tidak Tersedia!');
        }
        $this->reset('search');
    }

    public function updateCart($isAdded = true, $id)
    {
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
                        if(($orderProduct->quantity + 1) > $product->stock)
                        {
                            session()->flash('stock_error', 'Stock Tidak Cukup!');
                        } else {
                            $orderProduct->increment('quantity', 1);
                        }
                    }
                    else
                    {
                        $orderProduct->decrement('quantity', 1);
                        if ($orderProduct->quantity < 1) {
                            $this->removeCart($id);
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

        if ($orderProduct) {
            $order = \App\Models\Order::where('done_at', null)
                ->with('orderProducts')
                ->latest()
                ->first();

            if ($order) {
                $orderProductCount = $order->orderProducts->count();

                if ($orderProductCount > 1) {
                    $orderProduct->delete();
                } else {
                    $orderProduct->delete();
                    $order->delete();
                    $this->redirect('/order');
                }
            }
        }
    }

    public function confirmOrder()
    {
        $grand_total = $this->grand_total;

        $session_order_id = session('id_order');

        $order = \App\Models\Order::where('user_id', auth()->id())
                            ->where('done_at', null)
                            ->where('id', $session_order_id)
                            ->first();

        if ($order->member_id == null) {
            session()->flash('order_error', 'Member harus diisi!');
            return;
        }

        $order->update([
            'grand_total' => $grand_total,
        ]);

        $this->redirect('/payment');
    }


    public function member()
    {
        if ($this->phone_member != null) {
            $member = Member::where('phone', $this->phone_member)->first();
            $order = \App\Models\Order::where('user_id', auth()->id())
                    ->where('done_at', null)
                    ->latest()
                    ->first();

            if ($order) {
                if ($member) {
                    $order->update(['member_id' => $member->id]);
                    session()->flash('member_success', 'Member berhasil digunakan');
                } else {
                    $member = Member::firstOrCreate(['phone' => $this->phone_member]);
                    $order->update(['member_id' => $member->id]);
                    session()->flash('member_info', 'Member Baru');
                }
            }
        } else {
            session()->flash('member_error', 'Member harus diisi');
        }
    }

    public function discount()
    {
        // input user
        $discount_code = $this->discount_code;

        $promo = \App\Models\Promo::where('promo_code', $discount_code)->first();
        $order = \App\Models\Order::where('user_id', auth()->id())
                            ->where('done_at', null)
                            ->latest()
                            ->first();

        if($promo && ($promo->expired_at >= Carbon::now()))
        {
            $promo_type = $promo->discount_type;

            if($promo_type == 'Persen')
            {
                $discount_total_decimal = $promo->discount_value / 100; // convert to decimal (0.1)
                $discount_price = $this->order->total_price * $discount_total_decimal;
                $this->discount_price = $this->order->total_price * $discount_total_decimal;

                $order->update([
                   'discount_type' => $promo->discount_type,
                   'discount_price' => $discount_price
                ]);
                session()->flash('promo_success', 'Promo berhasil Digunakan');

            } else if($promo_type == 'Rupiah')
            {
                $order->update([
                    'discount_type' => $promo->discount_type,
                    'discount_price' => $promo->discount_value
                ]);
                $this->discount_price = $promo->discount_value;
                session()->flash('promo_success', 'Promo berhasil Digunakan');
            }

        } else {
            $this->discount_price = 0;
            $this->discount_total = 0;
            $this->grand_total = $this->total_price + $this->ppn;

            session()->flash('promo_error', 'Kode Diskon Tidak Valid');
        }
        return $this->discount_price;
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
