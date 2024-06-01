<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Livewire\Component;

class Order extends Component
{
    public $search = '';

    public function render()
    {
        $products = [];
        $produk = Product::all();
        if($this->search) {
            $products = Product::where('nama_produk', 'like', '%'.$this->search.'%')->get();
        }
        return view('livewire.cart.order', compact('products', 'produk'));
    }
}
