<a href="{{ route('clients.edit', $client) }}"
   class="text-[#702963] hover:underline"><i class="fas fa-edit"></i></a>

<form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this client?')"><i class="fas fa-trash"></i></button>
</form>
