<div class="w-64 bg-[#702963] text-white shrink-0">
    <div class="p-6 text-xl font-bold">FINTRASC</div>
    <nav class="space-y-4 px-6">
        <a href="{{ route('translation-jobs.create') }}" class="flex items-center gap-5 hover:text-purple-200">
        <i class="fa-solid fa-plus w-10 fa-2x"></i>
        <span>Enter new job</span>
    </a>
    <a href="{{ route('translation-jobs.index') }}" class="flex items-center gap-5 hover:text-purple-200">
        <i class="fa-solid fa-list w-10 fa-2x"></i>
        <span>Overview</span>
    </a>
        {{-- <a href="{{ route('invoices.index') }}" class="block hover:text-purple-200">Invoices</a>
        <a href="{{ route('clients.index') }}" class="block hover:text-purple-200">Clients</a>
        <a href="{{ route('stats.index') }}" class="block hover:text-purple-200">Stats</a> --}}
    </nav>
</div>
