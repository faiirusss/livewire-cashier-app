{{-- <div>
    <div class="py-12">
        <div class="py-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="max-w-md" wire:submit="createOrder">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="default-search" wire:model="search"
                        class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search Product..." required />
                    <button" type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Search</button>
                </div>
            </form>
        </div>

        <div class="py-5 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($products as $item)
                <div wire:click="updateCart('{{ $item->id }}')"
                    class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $item->nama_produk }}</h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">
                            Rp.{{ $item->harga }}</p>
                    </a>
                </div>

                @endforeach
            </div>
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>

                                <th scope="col" class="px-6 py-3">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Qty
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($order)
                            @foreach ($order->orderProducts as $item)

                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="p-4">
                                    <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/content-gallery-3.png"
                                        class="w-16 max-w-full max-h-full rounded-lg md:w-32" alt="Apple Watch">
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ $product->nama_produk }}
                                    {{ $item->product->nama_produk }}
                                </td>
                                <td class="px-6 py-4 ">
                                    {{ $item->quantity }}
                                    <div class="flex items-center">
                                        <button wire:click="updateCart(false, '{{ $item->product->id }}')"
                                            class="inline-flex items-center justify-center w-6 h-6 p-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full me-3 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                            type="button">
                                            <span class="sr-only">Quantity button</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 18 2">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                            </svg>
                                        </button>
                                        <div>
                                            <input type="number" id="first_product"
                                                class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ $item->quantity }}" required />
                                        </div>
                                        <button wire:click="updateCart(true, '{{ $item->product->id }}')"
                                            class="inline-flex items-center justify-center w-6 h-6 p-1 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full ms-3 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                            type="button">
                                            <span class="sr-only">Quantity button</span>
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 18 18">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    $599
                                    {{ $item->product->harga }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                        <svg class="inline w-6 h-6 text-red-600 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif


                        </tbody>
                        <tfoot>
                            <tr class="font-semibold text-gray-900 dark:text-white">
                                <th scope="row" class="px-6 py-3 text-base" colspan="2">Total</th>
                                <td class="px-6 py-3">3</td>
                                <td class="px-6 py-3">21,000</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="flex justify-end px-6 py-4">
                        <a href="/payment" wire:navigate
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Checkout
                            <svg class="w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 18 21">
                                <path
                                    d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div class="py-3 mx-auto max-w-7xl sm:px-6 lg:px-8">

        </div>
    </div>
</div> --}}
<div class="flex flex-row w-full h-screen overflow-hidden">
    <div class="w-8/12 border-e">
        <div class="px-2 py-5 mx-auto border-b max-w-screen sm:px-6 lg:px-8">
            <form class="flex" wire:submit="createOrder">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" wire:model="search" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600
                        dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan kode produk..." required autofocus />
                </div>
                <button type="submit"
                    class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </form>
        </div>

        <div class="">
            <div class="flex items-center px-8 py-4">
                <svg class="inline w-[24px] h-[24px] text-gray-800 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                </svg>
                <span class="text-lg font-bold">Keranjang</span>
            </div>

            <div class="p-6 mx-8 mb-5 overflow-y-auto border rounded-md max-h-[590px]">

                @if($order)
                {{-- @foreach($order->orderProducts as $item) --}}

                {{-- items --}}
                <div class="pb-5">
                    @foreach($order->orderProducts as $item)
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex-shrink-0 w-24">
                            <img src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/content/content-gallery-3.png"
                                class="w-full rounded" alt="{{ $item->product->nama_produk }}">
                        </div>
                        <div class="flex flex-col w-1/5 ms-5">
                            <span class="block font-bold text-md">{{ $item->product->product_name}}</span>
                            <span class="text-gray-500 truncate">{{ $item->product->color }}</span>
                        </div>
                        <div class="w-1/5 text-center">
                            <span>{{ $item->product->harga_formatted }}</span>
                        </div>
                        <div class="flex items-center justify-center w-1/5 mx-5">
                            <div class="flex items-center border border-gray-200 rounded">
                                <button type="button" wire:click="updateCart(false, '{{ $item->product->id }}')"
                                    class="px-2 leading-10 text-gray-600 transition size-10 hover:opacity-75">
                                    &minus;
                                </button>
                                <input type="number" id="Quantity" value="{{ $item->quantity }}"
                                    class="h-10 w-16 border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none" />
                                <button type="button" wire:click="updateCart(true, '{{ $item->product->id }}')"
                                    class="px-2 leading-10 text-gray-600 transition size-10 hover:opacity-75">
                                    &plus;
                                </button>
                            </div>
                        </div>
                        <div class="w-1/5 text-center">
                            <span>Rp{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex-shrink-0 ms-10">
                            <button type="button" wire:click="removeCart('{{ $item->product->id }}')">
                                <svg class="w-6 h-6 text-red-500 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>



                {{-- end items --}}
                {{-- @endforeach --}}
                @else
                <div>
                    <div class="text-center">
                        <svg class="w-auto h-56 mx-auto text-gray-300 sm:h-64" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                        </svg>

                        <p class="mt-4 text-gray-500">Keranjang masih kosong!</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
    {{-- end middle content --}}

    {{-- right content --}}
    <div class="flex flex-col w-4/12 max-h-screen bg-white">
        @if($order)

        <div class="px-2 py-7 max-w-screen sm:px-6 lg:px-8">
            <h3 class="pb-5 text-xl font-bold border-b">Ringkasan Belanja</h3>
        </div>

        <div class="px-8 pb-8 border-b border-gray-100">
            <div class="flow-root py-3 border border-gray-100 rounded-lg shadow-sm">
                <dl class="-my-3 text-sm divide-y divide-gray-200 divide-dashed">
                    <div class="flex justify-between p-3">
                        <dt class="font-medium text-gray-900">ID Pesanan</dt>
                        <dd class="text-gray-700 uppercase sm:col-span-2">{{ $order->invoice_number }}</dd>
                    </div>
                    <div class="flex justify-between p-3">
                        <dt class="font-medium text-gray-900">Tanggal</dt>
                        <dd class="text-gray-700 sm:col-span-2">{{
                            \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="px-8 pb-5 mt-5 border-b border-gray-100">

            <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Member
            </label>
            <div class="relative mb-2">
                <form wire:submit="member">
                    <div class="absolute inset-y-0 flex items-center px-2 pointer-events-none start-0 border-e">
                        <span class="text-sm text-gray-500">+62</span>
                    </div>
                    <input type="text" wire:model="phone_member"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan nomor telepon" required>
                </form>
            </div>
            <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">

                @if (session()->has('message'))
            <div class="text-sm text-green-800">
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            @endif
            </p>

            @if(session()->has('error'))
            <div class="text-sm text-red-800">
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            @endif
            {{-- @if (session('message'))
            <div class="text-sm text-green-800">
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            @elseif($order->member != null)
            <div class="text-sm text-green-800">
                <span class="font-medium">{{ $order->member->name }}</span>
            </div>
            @endif --}}
        </div>

        <div class="px-8 pb-5 mt-8 border-b border-gray-100">
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-900">Total Harga ({{ $total_qty }} barang)</span>
                <span class="text-sm font-medium text-gray-900">
                    @if ($total_price != 0)
                    <span>Rp{{ number_format($total_price, 0, ',', '.') }}</span>
                    @endif
                </span>
            </div>
            <div class="flex justify-between">
                @if($discount_code != '')
                <span class="text-sm font-medium text-gray-900">Total Diskon</span>
                <span class="text-sm font-medium text-gray-900">-Rp{{ number_format($discount_price, 0, ',', '.')
                    }}</span>
                @endif
            </div>
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-900">PPN 5%</span>
                <span class="text-sm font-medium text-gray-900">Rp{{ number_format($ppn, 0, ',', '.') }}</span>

            </div>
            <hr class="my-3">
            <div class="flex justify-between">
                <span class="text-lg font-bold text-gray-900">Total Belanja</span>
                <span class="text-lg font-bold text-gray-900">Rp{{ number_format($grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- diskon --}}
        <div class="px-8 pb-5 mt-8 border-b border-gray-100">
            <div class="relative mb-2">
                <form class="max-w-full mx-auto" wire:submit="discount">
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z" />
                            </svg>
                        </div>
                        <input type="text" wire:model="discount_code"
                            class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan kode promo" />
                        <button type="submit"
                            class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">pakai</button>
                    </div>
                </form>

            </div>
            @if($discount_code != '')
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-900">{{ $discount_total }} Diskon</span>
                <span class="text-sm font-medium text-blue-700">Rp{{ number_format($discount_price, 0, ',', '.')
                    }}</span>
            </div>
            @endif
        </div>

        <div class="px-8 pb-5 mt-5">
            <button type="button" wire:click="confirmOrder"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 w-full">
                Konfirmasi Pembayaran
            </button>
        </div>
        @endif
    </div>
    {{-- end right content --}}

</div>