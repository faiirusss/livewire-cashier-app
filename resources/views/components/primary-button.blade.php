<button {{ $attributes->merge(['type' => 'submit', 'class' => ' px-4 py-2 mt-6 mb-2 bg-blue-700 border
    border-transparent rounded-md font-md text-sm text-white tracking-widest hover:bg-blue-500
    focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
    transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>