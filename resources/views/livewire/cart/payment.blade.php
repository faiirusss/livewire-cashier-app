<div class="flex flex-row w-full h-screen overflow-hidden">
    <div class="w-8/12 border-e">
        <div class="px-2 py-5 mx-auto border-b max-w-screen sm:px-6 lg:px-8">
            <span class="text-xl font-semibold leading-6 text-gray-900">Metode Pembayaran</span>
        </div>

        <div class="pt-10">
            <div class="p-6 mx-8 border rounded-md">
                {{-- items --}}
                <div class="pb-5 space-y-4">
                    {{-- payement method --}}
                    <span class="font-medium text-gray-500 text-md">Silahkan pilih metode pembayaran anda</span>

                    <ul class="grid w-full gap-6 my-5 md:grid-cols-2">
                        <li>
                            <button type="button" class="w-full" data-modal-target="select-modal"
                                data-modal-toggle="select-modal">
                                <label for="cash"
                                    class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                    d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                            </svg>
                                        </div>
                                        <div class="w-full">Cash</div>
                                    </div>
                                    <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </label>
                            </button>
                        </li>
                        <li>
                            <button type="button" data-modal-target="select-modal-qris"
                                data-modal-toggle="select-modal-qris" class="w-full">
                                <label for="qris"
                                    class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                                            </svg>
                                        </div>
                                        <div class="w-full">Qris</div>
                                    </div>
                                    <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </label>
                            </button>
                        </li>
                    </ul>
                    {{-- end form payment method --}}
            </div>
            </div>
        </div>
    </div>
    {{-- end middle content --}}

    {{-- right content --}}
    <div class="flex flex-col w-4/12 max-h-screen bg-white">

    </div>
    {{-- end right content --}}

    {{-- modal --}}
    <div id="select-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-end p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        ID Transaksi #<span class="uppercase">{{ $order->invoice_number }}</span>
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="flex flex-col items-center pb-4 mb-3 border-b border-dashed">
                        <p class="mb-2 text-lg font-semibold">Transaksi dalam proses</p>
                        <span class="text-sm text-gray-500 ">{{
                            \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between pb-3 mb-3 border-b border-dashed">
                        <span class="text-sm font-normal text-gray-600">Metode Pembayaran</span>
                        <span class="text-sm font-normal text-gray-800">Cash</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">Total Harga ({{ $total_qty }})</span>
                        <span class="text-sm font-normal text-gray-800">Rp{{ number_format($total_price, 0, ',', '.')
                            }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">Total Diskon Barang</span>
                        <span class="text-sm font-normal text-gray-800">-Rp{{ number_format($order->discount_price, 0,
                            ',',
                            '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">PPN 5%</span>
                        <span class="text-sm font-normal text-gray-800">Rp{{ number_format(ceil($total_price * 0.05), 0,
                            ',',
                            '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">Total Pembayaran</span>
                        <span class="text-sm font-normal text-gray-800">{{ $paid_amount }}</span>
                    </div>
                    <div class="flex justify-between pb-3 mb-3 border-b border-dashed">
                        <span class="text-sm font-normal text-gray-600">Kembali</span>
                        <span class="text-sm font-normal text-gray-800">Cash</span>
                    </div>
                    <div class="flex justify-between pb-3 mb-3 border-b border-dashed">
                        <span class="text-lg font-bold text-gray-600">Total Belanja</span>
                        <span class="text-lg font-bold text-gray-800">Rp{{ number_format($order->grand_total, 0, ',',
                            '.') }}</span>
                    </div>
                    <div class="p-4 my-5 border-b">
                        <form class="max-w-full" wire:submit="payment">
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                    </svg>

                                </div>
                                <input type="number" wire:model="paid_amount" aria-describedby="helper-text-explanation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Masukkan Total Pembayaran" required />
                            </div>
                        </form>
                    </div>

                    <button
                        class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Next step
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- modal qris--}}
    <div id="select-modal-qris" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3>Qris</h3>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        ID Transaksi #<span class="uppercase">{{ $order->invoice_number }}</span>
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="flex flex-col items-center pb-4 mb-3 border-b border-dashed">
                        <p class="mb-2 text-lg font-semibold">Transaksi dalam proses</p>
                        <span class="text-sm text-gray-500 ">{{
                            \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between pb-3 mb-3 border-b border-dashed">
                        <span class="text-sm font-normal text-gray-600">Metode Pembayaran</span>
                        <span class="text-sm font-normal text-gray-800">Qris</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">Total Harga ({{ $total_qty }})</span>
                        <span class="text-sm font-normal text-gray-800">Rp{{ number_format($total_price, 0, ',', '.')
                            }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">Total Diskon Barang</span>
                        <span class="text-sm font-normal text-gray-800">-Rp{{ number_format($order->discount_price, 0,
                            ',',
                            '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">PPN 5%</span>
                        <span class="text-sm font-normal text-gray-800">Rp{{ number_format(ceil($total_price * 0.05), 0,
                            ',',
                            '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-normal text-gray-600">Total Pembayaran</span>
                        <span class="text-sm font-normal text-gray-800">Rp{{ number_format($order->grand_total, 0, ',',
                            '.') }}</span>
                    </div>
                    <div class="flex justify-between pb-3 mb-3 border-b border-dashed">
                        <span class="text-sm font-normal text-gray-600">Kembali</span>
                        <span class="text-sm font-normal text-gray-800">Rp0</span>
                    </div>
                    <div class="flex justify-between pb-3 mb-3 border-b border-dashed">
                        <span class="text-lg font-bold text-gray-600">Total Belanja</span>
                        <span class="text-lg font-bold text-gray-800">Rp{{ number_format($order->grand_total, 0, ',',
                            '.') }}</span>
                    </div>
                    <div class="w-full pb-3 mx-auto mb-5 border-b">
                        <svg class="w-[96px] h-[96px] text-gray-800 dark:text-white mx-auto" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                        </svg>
                    </div>

                    <button wire:click="pay_qris"
                        class="text-white inline-flex w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>