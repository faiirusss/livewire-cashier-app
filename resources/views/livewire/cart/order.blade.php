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
                        placeholder="Masukkan kode produk..." required autofocus autocomplete="off" />
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
            @if (session()->has('product_error'))
            <div class="flex items-center p-4 mx-8 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    {{ session('product_error') }}
                </div>
            </div>
            @endif

            <div class="p-6 mx-8 mb-5 overflow-y-auto border rounded-md max-h-[590px]">

                @if ($order)
                {{-- @foreach ($order->orderProducts as $item) --}}

                {{-- items --}}
                <div class="pb-5">
                    @foreach ($order->orderProducts as $item)
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex-shrink-0 w-24">
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full rounded"
                                alt="{{ $item->product->nama_produk }}">
                        </div>
                        <div class="flex flex-col w-1/5 ms-5">
                            <span class="block font-bold text-md">{{ $item->product->product_name }}</span>
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
    <div class="flex flex-col justify-between w-4/12 max-h-screen bg-white">
        @if ($order)
        {{-- title --}}
        <div class="px-2 py-7 max-w-screen sm:px-6 lg:px-8">
            <h3 class="pb-5 text-xl font-bold border-b">Ringkasan Belanja</h3>
        </div>

        {{-- info id & date --}}
        <div class="px-8 pb-8 border-b border-gray-100">
            <div class="flow-root py-3 border border-gray-100 rounded-lg shadow-sm">
                <dl class="-my-3 text-sm divide-y divide-gray-200 divide-dashed">
                    <div class="flex justify-between p-3">
                        <dt class="font-medium text-gray-900">ID Pesanan</dt>
                        <dd class="text-gray-700 uppercase sm:col-span-2">{{ $order->invoice_number }}</dd>
                    </div>
                    <div class="flex justify-between p-3">
                        <dt class="font-medium text-gray-900">Tanggal</dt>
                        <dd class="text-gray-700 sm:col-span-2">
                            {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- member --}}
        <div class="px-8 pb-5 mt-5 border-b border-gray-100">
            <label for="helper-text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Member
            </label>
            <div class="p-2 mb-2 border border-gray-200 rounded-md bg-gray-50" wire:ignore>
                <form wire:submit="member" class="flex">
                    <select id="phone-member" class="member mt-1.5 w-full rounded-lg"
                        data-placeholder="Masukkan Nomor Telepon" wire:model="phone_member">
                        @foreach ($members as $item)
                        <option value=""></option>
                        <option value="{{ $item->phone }}" data-name="{{ $item->name }}">
                            {{ $item->phone }}
                        </option>
                        @endforeach
                    </select>
                    <button
                        class="flex items-center px-3 text-sm text-white bg-blue-600 rounded-md font-sm font-semi ms-2">
                        kirim
                        <svg class="w-4 h-4 text-white ms-2 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 12H5m14 0-4 4m4-4-4-4" />
                        </svg>

                    </button>
                </form>
            </div>

            @if (session()->has('member_message'))
            @if ($phone_member)
            <div class="flex items-center gap-2 p-2 text-sm border border-gray-300 rounded-lg text-slate-800 bg-slate-100"
                role="alert">
                <svg class="w-4 h-4 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    {{ session('member_message') }}
                </div>
            </div>
            @else
            <div class="flex items-center gap-2 p-2 text-sm border border-red-100 rounded-lg bg-red-50 text-slate-800"
                role="alert">
                <svg class="w-4 h-4 text-red-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                        clip-rule="evenodd" />
                </svg>
                <div class="text-red-800">
                    {{ session('member_message') }}
                </div>
            </div>
            @endif
            @endif
            @if (session()->has('order_error'))
            <div class="flex items-center gap-2 p-2 text-sm border border-red-100 rounded-lg bg-red-50 text-slate-800"
                role="alert">
                <svg class="w-4 h-4 text-red-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                        clip-rule="evenodd" />
                </svg>
                <div class="text-red-800">
                    {{ session('order_error') }}
                </div>
            </div>
            @endif
        </div>

        {{-- detail info --}}
        <div class="px-8 pb-5 mt-5 border-b border-gray-100">
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-900">Total Harga ({{ $total_qty }} barang)</span>
                <span class="text-sm font-medium text-gray-900">
                    @if ($total_price != 0)
                    <span>Rp{{ number_format($total_price, 0, ',', '.') }}</span>
                    @endif
                </span>
            </div>
            <div class="flex justify-between">
                @if ($discount_code != '')
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

        {{-- discount --}}
        <div class="px-8 pb-4 mt-5 border-b border-gray-100">
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
                            class="block w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Masukkan kode promo" />
                        <button type="submit"
                            class="absolute inset-y-1.5 px-5 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg end-1.5 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pakai</button>
                    </div>
                </form>
            </div>
            @if ($discount_code != '')
            @if (session()->has('promo_message'))
            @if ($discount_price > 0)
            <div class="flex items-center justify-between mt-4">
                <span class="flex gap-1 text-sm font-medium text-gray-900">
                    <svg class="w-4 h-4 text-blue-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M20.29 8.567c.133.323.334.613.59.85v.002a3.536 3.536 0 0 1 0 5.166 2.442 2.442 0 0 0-.776 1.868 3.534 3.534 0 0 1-3.651 3.653 2.483 2.483 0 0 0-1.87.776 3.537 3.537 0 0 1-5.164 0 2.44 2.44 0 0 0-1.87-.776 3.533 3.533 0 0 1-3.653-3.654 2.44 2.44 0 0 0-.775-1.868 3.537 3.537 0 0 1 0-5.166 2.44 2.44 0 0 0 .775-1.87 3.55 3.55 0 0 1 1.033-2.62 3.594 3.594 0 0 1 2.62-1.032 2.401 2.401 0 0 0 1.87-.775 3.535 3.535 0 0 1 5.165 0 2.444 2.444 0 0 0 1.869.775 3.532 3.532 0 0 1 3.652 3.652c-.012.35.051.697.184 1.02ZM9.927 7.371a1 1 0 1 0 0 2h.01a1 1 0 0 0 0-2h-.01Zm5.889 2.226a1 1 0 0 0-1.414-1.415L8.184 14.4a1 1 0 0 0 1.414 1.414l6.218-6.217Zm-2.79 5.028a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01Z"
                            clip-rule="evenodd" />
                    </svg>
                    Diskon {{ $discount_total }} {{ session('promo_message ') }}
                </span>
                <span class="text-sm font-medium text-blue-700">
                    Rp{{ number_format($discount_price, 0, ',', '.') }}
                </span>
            </div>
            @else
            <div class="flex items-center gap-2 p-2 text-sm border border-red-100 rounded-lg bg-red-50 text-slate-800"
                role="alert">
                <svg class="w-4 h-4 text-red-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v5a1 1 0 1 0 2 0V8Zm-1 7a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                        clip-rule="evenodd" />
                </svg>
                <div class="text-red-800">
                    {{ session('promo_message') }}
                </div>
            </div>
            @endif
            @endif
            @endif

        </div>

        {{-- button --}}
        <div class="px-8 pb-5 mt-5">
            <button type="button" wire:click="confirmOrder"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 w-full">
                Konfirmasi Pembayaran
            </button>
        </div>
        @endif
    </div>
    {{-- end right content --}}

    <script>
        $(document).ready(function() {
             function formatResult(option) {
                 if (!option.id) {
                     return option.text;
                 }
                 var name = $(option.element).data('name');
                 return name ? name : option.text;
             }

             function formatSelection(option) {
                 if (!option.id) {
                     return option.text;
                 }
                 var name = $(option.element).data('name');
                 return name ? name : option.text;
             }

             $('.member').select2({
                 placeholder: 'Masukkan Nomor Telepon',
                 allowClear: true,
                 minimumInputLength: 2,
                 minimumResultsForSearch: 1,
                 tags: true,
                 language: {
                     inputTooShort: function(args) {
                         var remainingChars = args.minimum - args.input.length;
                         return 'Ketikkan minimal ' + remainingChars + ' karakter';
                     }
                 },
                 templateResult: formatResult,
                 templateSelection: formatSelection
             });

             $('#phone-member').on('change', function(e) {
                 var data = $('#phone-member').select2("val")
                 @this.set('phone_member', data)
             })
         });
    </script>

</div>