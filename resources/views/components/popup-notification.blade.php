<div x-data="{ show: true, timeout: null }" x-init="timeout = setTimeout(() => show = false, {{ $timeout ?? 5000 }})"
    x-show="show" x-transition class="absolute z-50 right-10 top-10">
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
