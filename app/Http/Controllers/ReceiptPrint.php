<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReceiptPrint extends Controller
{
    public function index()
    {
        $order = Order::where('done_at', null)
            ->with('orderProducts')
            ->latest()
            ->first();

        $data = [
            'order' => $order,
        ];

        $pdf = Pdf::loadView('livewire.cart.receipt', $data);
        $pdf->setPaper([0, 0, 165, 500], 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
