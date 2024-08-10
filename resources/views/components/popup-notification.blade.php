<div x-data="{ show: true, timeout: null }" x-init="timeout = setTimeout(() => show = false, {{ $timeout ?? 5000 }})"
    x-show="show" x-transition:enter="transition transform ease-out duration-700"
    x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition transform ease-in duration-700" x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0" class="absolute top-0 right-0 z-50 p-4">
    <div role="alert" class="p-3 bg-white border border-gray-200 rounded-xl w-80">
        <div class="flex items-center gap-4">
            <span class="{{ $iconColor }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
                </svg>
            </span>

            <div class="flex-1">
                <strong class="block text-base font-medium text-gray-900"> {{ $message }} </strong>
            </div>

            <button @click="show = false; clearTimeout(timeout);" class="text-gray-500 transition hover:text-gray-600">
                <span class="sr-only">Dismiss popup</span>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>
