<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#702963] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#8a3379] focus:bg-[#8a3379] active:bg-[#5a1f4d] focus:outline-none focus:ring-2 focus:ring-[#702963] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
