<div>
    <x-slot name="header">
        <ol
            class="flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse">

            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    1
                </span>
                Order <span class="hidden sm:inline-flex sm:ms-2">Info</span>
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center text-blue-600 dark:text-blue-500">
                <span
                    class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
                    2
                </span>
                Payment <span class="hidden sm:inline-flex sm:ms-2">Method</span>
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                    3
                </span>
                Finish
            </li>
        </ol>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="w-full max-w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <a href="/order" wire:navigate class="flex space-x-2 mb-5">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14M5 12l4-4m-4 4 4 4" />
                    </svg> <span>Order</span>
                </a>
                @if ($order)
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-black leading-none  dark:text-white">Order Details
                        <span class="uppercase">#{{$order->invoice_number}}</span>
                    </h2>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-500">
                        Active
                    </span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Date: {{ $order->created_at->format('d/m/Y')
                        }}</span>
                </div>
                @endif

                <div class="flow-root">
                    <div class="flex items-center justify-between my-10">
                        <h5 class="text-md font-bold text-black leading-none  dark:text-white">Item Ordered</h5>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-1 lg:gap-8 mb-20">
                        <div class="min-h-min rounded-lg bg-gray-200 p-5">
                            <div class="">
                                <ul class="max-w-md divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($orderProduct as $item)
                                    <li class="pb-3 sm:pb-4">
                                        <div class="flex items-center justify-between space-x-4 rtl:space-x-reverse">
                                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                                <div class="flex-shrink-0">
                                                    <img class="w-8 h-8 rounded-lg"
                                                        src="{{ Str::startsWith($item->product->image, ['http://', 'https://']) ? $item->product->image : asset('/storage/product/' . $item->product->image) }}"
                                                        alt="product">
                                                </div>
                                                <div class="w-64 min-w-0">
                                                    <p
                                                        class="text-sm font-black capitalize text-black truncate dark:text-white">
                                                        {{ $item->product->nama_produk }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        email@flowbite.com
                                                    </p>
                                                </div>
                                            </div>
                                            <div
                                                class="flex-1 flex justify-center items-center space-x-4 rtl:space-x-reverse">
                                                <div class="text-base font-semibold text-gray-500 dark:text-white">
                                                    Hijau
                                                </div>
                                                <div class="w-32 text-base font-semibold text-gray-500 dark:text-white">
                                                    {{ $item->quantity }}Pcs
                                                </div>
                                            </div>
                                            <div
                                                class="w-64 text-right text-base font-semibold text-gray-900 dark:text-white">
                                                Rp.{{ $item->price }}
                                            </div>
                                        </div>

                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h5 class="text-md font-bold text-black leading-none  dark:text-white">Payment Method</h5>
                    <span class="text-sm font-medium text-gray-500">Choose your payment method</span>

                    <form>
                        <ul class="grid w-full gap-6 md:grid-cols-2 my-5">
                            <li>
                                <input type="radio" value="cash" wire:click="payment_method('cash')" id="cash"
                                    name="payment_method" class="hidden peer" required />
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
                            </li>
                            <li>
                                <input type="radio" wire:click="payment_method('qris')" id="qris" name="payment_method"
                                    value="qris" class="hidden peer">
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
                            </li>
                        </ul>
                    </form>

                    @if($order->payment_method == 'qris')
                    <div class="flex justify-end">
                        <button data-modal-target="modal-qris" data-modal-toggle="modal-qris"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 18 21">
                                <path
                                    d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                            </svg>
                            Confirm Order
                        </button>
                    </div>
                    @elseif($order->payment_method == 'cash')
                    <div class="flex justify-end">
                        <button data-modal-target="modal-cash" data-modal-toggle="modal-cash" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                            focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex
                            items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 18 21">
                                <path
                                    d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                            </svg>
                            Confirm Order
                        </button>
                    </div>
                    @endif
                </div>

                {{-- modal --}}

                <div id="modal-qris" tabindex="-1"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <form wire:submit="done">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <div class="p-4 md:p-5 text-center flex flex-col items-center">
                                    <svg class="w-24 h-24 text-gray-800 dark:text-white mb-4" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z" />
                                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z" />
                                    </svg>

                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        Done
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <div id="modal-cash" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                            </div>
                            <!-- Modal body -->
                            <form class="p-4 md:p-5" wire:submit="done">
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total
                                            Cash
                                        </label>
                                        <input type="number" name="paid_amount" id="paid_amount"
                                            wire:model="paid_amount"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="enter the amount of money">
                                    </div>
                                </div>
                                <button type="submit"
                                    class="text-white w-full inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <div class="text-center flex-grow flex justify-center items-center">Done</div>
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>