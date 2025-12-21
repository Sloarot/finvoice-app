<a href="{{ route('clients.edit', $client) }}"
   class="text-[#702963] hover:underline">Edit</a>

<form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
    @csrf @method('DELETE')
    <button class="text-red-500 hover:underline ml-2">Delete</button>
</form>
