<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Sidebar extends Component
{
    use WithPagination, WithoutUrlPagination; 

    public function render()
    {
        $orders = Order::whereNotNull('done_at')
            ->latest()
            ->get();

        return view('livewire.sidebar', [
            'orders' => $orders
        ]);
    }
}
