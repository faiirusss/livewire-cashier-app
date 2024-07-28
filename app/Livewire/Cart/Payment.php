<?php

namespace App\Livewire\Cart;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

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
        $this->ppn = ceil($this->total_price * 0.11);

        return view('livewire.cart.payment', [
            'order' => $this->order,
            // 'orderProduct' => $orderProduct
        ]);
    }

    public function payment_cash()
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

            foreach ($this->order->orderProducts as $itemProduct) {
                $product = Product::find($itemProduct->product_id);
                if ($product) {
                    $product->decrement('stock', $itemProduct->quantity);
                }
            }

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

    public function pay_cash()
    {
        $this->order = Order::where('done_at', null)
        ->with('orderProducts')
        ->latest()
        ->first();

        $this->order->update([
            'done_at' => now()
        ]);

        $orderId = strtoupper($this->order->invoice_number);
        $cashier = auth()->user()->name; // Assuming the cashier is the authenticated user
        $member = $this->order->member->name ?? $this->order->member->phone;
        $address = 'Jl. Binong Jati No.124'; // Replace with actual address
        $address2 = 'Kec.Batununggal, Bandung, 40275'; // Replace with actual address
        $phone = '0856-2401-0106'; // Replace with actual phone number
        $date = $this->order->created_at->format('Y-m-d H:i');
        $pembayaran = $this->order->payment_method;
        $bayar = $this->order->paid_amount;
        $kembali = $this->order->return_amount;


        function centerTextCash($text, $width = 32) {
            if (strlen($text) >= $width) {
                return $text;
            }
            $padding = floor(($width - strlen($text)) / 2);
            return str_repeat(' ', $padding) . $text;
            }

        // Format the receipt text
        $text = centerTextCash('Merajut Asa') . "\n";
        $text .= centerTextCash($address) . "\n";
        $text .= centerTextCash($address2) . "\n";
        $text .= centerTextCash($phone) . "\n\n";

        $text .= "Tanggal   : $date\n";
        $text .= "Order ID  : $orderId\n";
        $text .= "Kasir     : $cashier\n";
        $text .= "Member    : $member\n";
        $text .= "--------------------------------\n";

        $nameWidth = 16;
        $qtyWidth = 5;
        $priceWidth = 11;
        $this->total_qty = 0;
        $this->total_price = 0;

        foreach ($this->order->orderProducts as $product) {
            $productName = $product->product->product_name;
            $quantity = $product->quantity;
            $totalPrice = number_format($product->unit_price * $quantity);
            $this->total_qty += $quantity;
            $this->total_price += $product->unit_price * $product->quantity;
            $diskon = number_format($this->order->discount_price);

            $paddedName = str_pad($productName, $nameWidth);
            $paddedQty = str_pad($quantity, $qtyWidth, ' ', STR_PAD_LEFT);
            $paddedPrice = str_pad($totalPrice, $priceWidth, ' ', STR_PAD_LEFT);

            $text .= "$paddedName$paddedQty$paddedPrice\n";
        }
        $textTotalBarang = str_pad("Total Barang", $nameWidth);
        $totalBarang = str_pad($this->total_qty, $qtyWidth, ' ', STR_PAD_LEFT);

        // $text .= "$textTotalBarang$totalBarang\n";

        $text .= "--------------------------------\n";

        $space = str_pad("", 3, ' ', STR_PAD_LEFT);
        $spaceTotal = str_pad("", 2, ' ', STR_PAD_LEFT);
        $textSubtotal = str_pad("Subtotal " . $this->total_qty . " Produk", 18);
        $subtotal = str_pad(number_format($this->total_price), 12, ' ', STR_PAD_LEFT);
        $text .= "$textSubtotal$spaceTotal$subtotal\n";

        $textDiskon = str_pad("Diskon", 17);
        $diskon = str_pad($diskon, 12, ' ', STR_PAD_LEFT);
        $text .= "$textDiskon$space$diskon\n";

        $this->ppn = ceil($this->total_price * 0.05);
        $textPpn = str_pad("PPN", 17);
        $ppn = str_pad(number_format($this->ppn), 12, ' ', STR_PAD_LEFT);
        $text .= "$textPpn$space$ppn\n";

        $text .= "--------------------------------\n";

        $textTotal = str_pad("Total", 17);
        $total = str_pad(number_format($this->order->grand_total), 12, ' ', STR_PAD_LEFT);
        $text .= "$textTotal$space$total\n";

        $textPembayaran = str_pad("Pembayaran", 17);
        $pembayaranValue = str_pad($pembayaran, 12, ' ', STR_PAD_LEFT);
        $text .= "$textPembayaran$space$pembayaranValue\n";

        $textBayar = str_pad("Bayar", 17);
        $bayar = str_pad(number_format($bayar), 12, ' ', STR_PAD_LEFT);
        $text .= "$textBayar$space$bayar\n";

        $textKembali = str_pad("Kembali", 17);
        $kembali = str_pad(number_format($kembali), 12, ' ', STR_PAD_LEFT);
        $text .= "$textKembali$space$kembali\n";

        $text .= "--------------------------------\n";
        $text .= centerTextCash('Terima Kasih') . "\n";

        try {
            $connector = new WindowsPrintConnector("RP58-Printer");
            $printer = new Printer($connector);
            $printer->text($text);
            $printer->cut();
            $printer->close();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

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
            'done_at' => now(),
            'return_amount' => 0
        ]);

        foreach ($this->order->orderProducts as $itemProduct) {
            $product = Product::find($itemProduct->product_id);
            if ($product) {
                $product->decrement('stock', $itemProduct->quantity);
            }
        }

        $orderId = strtoupper($this->order->invoice_number);
        $cashier = auth()->user()->name; // Assuming the cashier is the authenticated user
        $member = $this->order->member->name ?? $this->order->member->phone;
        $address = 'Jl. Binong Jati No.124'; // Replace with actual address
        $address2 = 'Kec.Batununggal, Bandung, 40275'; // Replace with actual address
        $phone = '0856-2401-0106'; // Replace with actual phone number
        $date = $this->order->created_at->format('Y-m-d H:i');
        $pembayaran = 'Qris';
        $bayar = $this->order->paid_amount;
        $kembali = 0;


        function centerText($text, $width = 32) {
            if (strlen($text) >= $width) {
                return $text; // If the text is longer than or equal to the width, return it as is.
            }
            $padding = floor(($width - strlen($text)) / 2);
            return str_repeat(' ', $padding) . $text;
            }

        // Format the receipt text
        $text = centerText('Merajut Asa') . "\n";
        $text .= centerText($address) . "\n";
        $text .= centerText($address2) . "\n";
        $text .= centerText($phone) . "\n\n";

        $text .= "Tanggal   : $date\n";
        $text .= "Order ID  : $orderId\n";
        $text .= "Kasir     : $cashier\n";
        $text .= "Member    : $member\n";
        $text .= "--------------------------------\n";

        $nameWidth = 16;
        $qtyWidth = 5;
        $priceWidth = 11;
        $this->total_qty = 0;
        $this->total_price = 0;

        foreach ($this->order->orderProducts as $product) {
            $productName = $product->product->product_name;
            $quantity = $product->quantity;
            $totalPrice = number_format($product->unit_price * $quantity);
            $this->total_qty += $quantity;
            $this->total_price += $product->unit_price * $product->quantity;
            $diskon = number_format($this->order->discount_price);

            $paddedName = str_pad($productName, $nameWidth);
            $paddedQty = str_pad($quantity, $qtyWidth, ' ', STR_PAD_LEFT);
            $paddedPrice = str_pad($totalPrice, $priceWidth, ' ', STR_PAD_LEFT);

            $text .= "$paddedName$paddedQty$paddedPrice\n";
        }
        // $textTotalBarang = str_pad("Total Barang", $nameWidth);
        // $totalBarang = str_pad($this->total_qty, $qtyWidth, ' ', STR_PAD_LEFT);

        // $text .= "$textTotalBarang$totalBarang\n";
        $text .= "--------------------------------\n";

        $space = str_pad("", 3, ' ', STR_PAD_LEFT);
        $spaceTotal = str_pad("", 2, ' ', STR_PAD_LEFT);

        $textSubtotal = str_pad("Subtotal " . $this->total_qty . " Produk", 18);
        $subtotal = str_pad(number_format($this->total_price), 12, ' ', STR_PAD_LEFT);
        $text .= "$textSubtotal$spaceTotal$subtotal\n";

        $textDiskon = str_pad("Diskon", 17);
        $diskon = str_pad($diskon, 12, ' ', STR_PAD_LEFT);
        $text .= "$textDiskon$space$diskon\n";

        $this->ppn = ceil($this->total_price * 0.05);
        $textPpn = str_pad("PPN", 17);
        $ppn = str_pad(number_format($this->ppn), 12, ' ', STR_PAD_LEFT);
        $text .= "$textPpn$space$ppn\n";

        $text .= "--------------------------------\n";

        $textTotal = str_pad("Total", 17);
        $total = str_pad(number_format($this->order->grand_total), 12, ' ', STR_PAD_LEFT);
        $text .= "$textTotal$space$total\n";

        $textPembayaran = str_pad("Pembayaran", 17);
        $pembayaranValue = str_pad($pembayaran, 12, ' ', STR_PAD_LEFT);
        $text .= "$textPembayaran$space$pembayaranValue\n";

        $textBayar = str_pad("Bayar", 17);
        $bayar = str_pad(number_format($bayar), 12, ' ', STR_PAD_LEFT);
        $text .= "$textBayar$space$bayar\n";

        $textKembali = str_pad("Kembali", 17);
        $kembali = str_pad(number_format($kembali), 12, ' ', STR_PAD_LEFT);
        $text .= "$textKembali$space$kembali\n";

        $text .= "--------------------------------\n";
        $text .= centerText('Terima Kasih') . "\n";

        try {
            $connector = new WindowsPrintConnector("RP58-Printer");
            $printer = new Printer($connector);
            $printer->text($text);
            $printer->cut();
            $printer->close();
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
        return redirect()->route('order');
    }

}
