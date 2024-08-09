<div class="flex flex-row w-full h-screen pb-2 overflow-hidden">

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
            <x-popup-notification :message="session('product_error')" :timeout="2000"
                iconPath="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" iconColor="text-red-800"
                textColor="text-red-800" />
            @endif
            @if (session()->has('stock_error'))
            <x-popup-notification :message="session('stock_error')" :timeout="2000"
                iconPath="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" iconColor="text-red-800"
                textColor="text-red-800" />
            @endif

            <div class="p-2 mx-5 mb-5 overflow-y-auto border rounded-md" style="max-height: calc(80vh - 80px);">

                @if ($order)

                {{-- items --}}
                <div class="pb-3">
                    @foreach ($order->orderProducts as $item)
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex-shrink-0 w-10">
                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full rounded"
                                alt="{{ $item->product->product_name }}">
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

                        <div class="flex-1 ms-5">
                            <button type="button" wire:click="removeCart('{{ $item->product->id }}')">
                                <svg class="w-5 h-5 text-red-500 dark:text-white" aria-hidden="true"
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

            @if (session()->has('member_success'))
            @if($phone_member)
            <x-popup-notification :message="session('member_success')" :timeout="5000" iconPath="M6 18L18 6M6 6l12 12"
                iconColor="text-green-900" textColor="text-green-900" />
            @endif
            @endif

            @if(session()->has('member_info'))
            <x-popup-notification :message="session('member_info')" :timeout="5000" iconPath="M6 18L18 6M6 6l12 12"
                iconColor="text-orange-900" textColor="text-orange-900" />
            @endif

            @if(session()->has('member_error'))
            <x-popup-notification :message="session('member_error')" :timeout="5000" iconPath="M6 18L18 6M6 6l12 12"
                iconColor="text-blue-900" textColor="text-blue-900" />
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
                <span class="text-sm font-medium text-gray-900">PPN 11%</span>
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
            @if (session()->has('promo_success'))
            @if ($discount_price > 0)
            <x-popup-notification :message="session('promo_success')" :timeout="5000" iconPath="M6 18L18 6M6 6l12 12"
                iconColor="text-green-900" textColor="text-green-900" />
            @endif
            @else
            <x-popup-notification :message="session('promo_error')" :timeout="5000" iconPath="M6 18L18 6M6 6l12 12"
                iconColor="text-green-900" textColor="text-green-900" />
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
        @if (session()->has('order_error'))
        <x-popup-notification :message="session('order_error')" :timeout="2000"
            iconPath="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
            iconColor="text-red-800" textColor="text-red-800" />
        @endif

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
