<div class="w-64 bg-[#702963] text-white shrink-0">
    <div class="p-6 flex justify-center"><img src="{{ asset('images/logo3.png') }}" alt="FINTRASC" class="h-16 w-auto"></div>
    <nav class="space-y-8 px-9 mt-8">
        <a href="{{ route('translation-jobs.create') }}" class="flex items-center gap-8 uppercase hover:text-yellow-400 text-xl">
        <i class="fa-solid fa-plus-square w-10 fa-2x"></i>
        <span>New job</span>
    </a>
    <a href="{{ route('translation-jobs.index') }}" class="flex items-center gap-8 uppercase hover:text-yellow-400 text-xl">
        <i class="fa-solid fa-list w-10 fa-2x"></i>
        <span>Overview</span>
    </a>
    <a href="{{ route('clients.index') }}" class="flex items-center gap-8 uppercase hover:text-yellow-400 text-xl">
        <i class="fa-solid fa-address-card  w-10 fa-2x"></i>
        <span>Clients</span>
    </a>
     <a href="{{ route('invoices.index') }}" class="flex items-center gap-8 uppercase hover:text-yellow-400 text-xl">
        <i class="fa-solid fa-file-lines w-10 fa-2x"></i>
        <span>Invoices</span>
    </a>
     <a href="{{ route('chart') }}" class="flex items-center gap-8 uppercase hover:text-yellow-400 text-xl">
        <i class="fa-solid fa-chart-line w-10 fa-2x"></i>
        <span>Charts</span>
    </a>
    </nav>
</div>
