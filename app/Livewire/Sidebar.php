<?php

namespace App\Livewire;

use App\Livewire\Actions\Logout;

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

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}
