<div class="flex space-x-2">
    <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600 hover:text-blue-800">View</a>
    <a href="{{ route('invoices.edit', $invoice) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this invoice?')">Delete</button>
    </form>
</div>
