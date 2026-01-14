<div class="flex space-x-2">
    <a href="{{ route('invoices.show', $invoice) }}"
       class="inline-flex items-center justify-center w-8 h-8 rounded bg-[#5a4870] text-white hover:bg-[#6d5a85] transition-colors">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('invoices.edit', $invoice) }}"
       class="inline-flex items-center justify-center w-8 h-8 rounded bg-[#702963] text-white hover:bg-[#8a3479] transition-colors">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="inline-flex items-center justify-center w-8 h-8 rounded bg-[#9b4d8f] text-white hover:bg-[#b05fa3] transition-colors"
                onclick="return confirm('Are you sure you want to delete this invoice?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
