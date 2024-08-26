<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            margin: 3px;
            padding: 0;
            width: 100%;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        h3,
        p {
            margin: 0;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details td {
            padding: 0;
            margin: 0;
            vertical-align: top;
        }

        .label {
            width: 25%;
        }

        .dot {
            width: 5%;
            text-align: center;
        }

        .value {
            width: 70%;
        }

        .product_name {
            width: 55%;
        }

        .product_qty {
            width: 5%;
            text-align: center;
        }

        .product_price {
            width: 40%;
        }

        .detail-text {
            width: 85%;
        }

        .detail-number {
            width: 15%;
        }



        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            margin-bottom: 3px;
        }

        hr {
            border-style: dashed;
            border-width: 1px 0 0 0;
            color: #000;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <p>Merajut Asa Kita</p>
            <p><small>Jl. Binong Jati No.124</small></p>
            <p><small>Kec.Batununggal, Bandung, 40275</small></p>
            <p><small>0856-2401-0106</small></p>
        </div>
        <hr>
        <div class="details">
            <table>
                <tr>
                    <td class="label">Tanggal</td>
                    <td class="dot">:</td>
                    <td class="value">{{ date('Y-m-d H:i:s', strtotime($order->created_at)) }}</td>
                </tr>
                <tr>
                    <td class="label">Order ID</td>
                    <td class="dot">:</td>
                    <td class="value">{{ strtoupper($order->invoice_number) }}</td>
                </tr>
                <tr>
                    <td class="label">Kasir</td>
                    <td class="dot">:</td>
                    <td class="value">{{ ucwords($order->user->name) }}</td>
                </tr>
                <tr>
                    <td class="label">Member</td>
                    <td class="dot">:</td>
                    <td class="value">{{ ucwords($order->member->name) }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="details">
            <table>
                @php
                $totalQty = 0;
                $totalPrice = 0;
                @endphp
                @foreach ($order->orderProducts as $item)
                @php
                $product_name = $item->product->product_name;
                $quantity = $item->quantity;
                $priceUnit = $item->unit_price * $quantity;
                $totalPrice += $item->unit_price * $quantity;
                $totalQty += $quantity;
                $grandTotal = $order->grand_total;
                $diskon = $item->diskon_price;
                $ppn = ceil($totalPrice * 0.11);
                $pembayaran = $order->payment_method ?? 'Qris';
                $bayar = $order->paid_amount ?? 0;
                $kembali = $order->return_amount ?? 0;
                @endphp
                <tr>
                    <td class="product_name">{{ $product_name }}</td>
                    <td class="product_qty">{{ $quantity }}</td>
                    <td align="right" class="product_price" style="padding-right: 10px;">{{ number_format($priceUnit)
                        }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <hr>
        <div class="details">
            <table>
                <tr>
                    <td class="detail_text" style="width: 80%;">Subtotal {{ $totalQty }} Produk</td>
                    <td class="detail_number" align="right" style="width: 20%; padding-right: 10px;">{{
                        number_format($totalPrice)
                        }}</td>
                </tr>
                <tr>
                    <td class="detail_text" style="width: 80%;">Diskon</td>
                    <td class="detail_number" align="right" style="width: 20%; padding-right: 10px;">{{
                        number_format($diskon)
                        }}</td>
                </tr>
                <tr>
                    <td class="detail_text" style="width: 80%;">PPN 11%</td>
                    <td class="detail_number" align="right" style="width: 20%; padding-right: 10px;">{{
                        number_format($ppn)
                        }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="details">
            <table>
                <tr>
                    <td class="detail_text" style="width: 80%;">Total</td>
                    <td class="detail_number" align="right" style="width: 20%; padding-right: 10px;">{{
                        number_format($grandTotal)
                        }}</td>
                </tr>
                <tr>
                    <td class="detail_text" style="width: 80%;">Pembayaran</td>
                    <td class="detail_number" align="right" style="width: 20%; padding-right: 10px;">{{$pembayaran}}
                    </td>
                </tr>
                <tr>
                    <td class="detail_text" style="width: 80%;">Bayar</td>
                    <td class="detail_number" align="right" style="width: 20%; padding-right: 10px;">{{
                        number_format($bayar)
                        }}</td>
                </tr>
                <tr>
                    <td class="detail_text" style="width: 80%;">Kembali</td>
                    <td class="detail_number" align="right" style="width: 20%; padding-right: 10px;">{{
                        number_format($kembali)
                        }}</td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="header" style="margin-top: 20px;">
            <p>Terima Kasih</p>
        </div>
    </div>
</body>

</html>