<div>
    <div class="flex flex-col justify-between w-auto h-screen bg-white border-e">
        <div>
            <div class="inline-flex items-center justify-center w-full py-5 ">
                <button class="type=" button" data-drawer-target="drawer-navigation"
                    data-drawer-show="drawer-navigation" aria-controls="drawer-navigation"">
        <span
          class="grid text-xs text-gray-500 rounded-lg hover:bg-gray-50 hover:text-gray-700 size-10 place-content-center">
                    <svg class="opacity-75 size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h14" />
                    </svg>
                    </span>
                </button>
            </div>
            <div class="">
                <div class="px-2">
                    <div class="py-4">

                    </div>
                </div>
            </div>
        </div>
        <div class="sticky inset-x-0 bottom-0 p-2 bg-white border-t border-gray-100">
            <button wire:click="logout"
                class="group relative flex w-full justify-center rounded-lg px-2 py-1.5 text-sm text-gray-500 hover:bg-gray-50 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="opacity-75 size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span
                    class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded bg-gray-900 px-2 py-1.5 text-xs font-medium text-white group-hover:visible">
                    {{ __('Log Out') }}
                </span>
            </button>
        </div>
    </div>

    {{-- sidebar --}}
    <div id="drawer-navigation"
        class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80 dark:bg-gray-800"
        tabindex="-1" aria-labelledby="drawer-navigation-label">
        <div class="py-5 border-b">
            <span id="drawer-navigation-label" class="text-lg font-semibold text-gray-800 dark:text-gray-400">
                Daftar Pembelian
            </span>
            <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>

        {{-- search --}}
        <div class="py-5">
            <form class="max-w-md mx-auto">
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
                    <input type="search" id="default-search"
                        class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Cari data pembelian..." required />
                </div>
            </form>
        </div>
        {{-- end search --}}

        <div class="py-4 overflow-y-auto max-h-[510px] overflow-x-hidden">
            @foreach($orders as $order)
            <article class="mb-5 bg-white border-2 border-gray-100 rounded-xl">
                <div class="flex items-start gap-3 p-4 sm:p-6 lg:p-8">
                    <div>
                        <h3 class="font-bold text-black text-md">
                            ID Pesanan
                            <span class="font-bold text-black uppercase text-md">#{{ $order->invoice_number}}</span>
                        </h3>
                        <div class=" sm:flex sm:items-center sm:gap-2">
                            <div class="flex items-center gap-1 text-gray-500">
                                <p class="text-md">{{ $order->member->name ?? $order->member->phone }}</p>
                            </div>
                            <span class="hidden sm:block" aria-hidden="true">&middot;</span>
                            <div class="flex items-center gap-1 text-gray-500">
                                <p class="text-md">{{ $order->payment_method }}</p>
                            </div>
                        </div>
                        <span class="text-sm text-gray-400">Rp{{ number_format($order->grand_total, 0, ',',
                            '.')
                            }}</span>

                        <span
                            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                            {{ \Carbon\Carbon::parse($order->done_at)->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div class="flex justify-end">
                    <strong
                        class="-mb-[2px] -me-[2px] inline-flex items-center gap-1 rounded-ee-xl rounded-ss-xl bg-green-600 px-3 py-1.5 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>

                        <span class="text-[10px] font-medium sm:text-xs">selesai</span>
                    </strong>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    {{-- end sidebar --}}
</div>