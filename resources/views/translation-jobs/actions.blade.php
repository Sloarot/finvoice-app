<a href="{{ route('translation-jobs.edit', $job) }}"
   class="text-[#702963] hover:underline">Edit</a>

<form action="{{ route('translation-jobs.destroy', $job) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button class="text-red-500 hover:underline ml-2">Delete</button>
</form>
