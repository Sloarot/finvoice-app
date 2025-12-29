<a href="{{ route('translation-jobs.edit', $job) }}"
   class="text-[#702963] hover:underline"><i class="fas fa-edit"></i></a>

<form action="{{ route('translation-jobs.destroy', $job) }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button class="text-red-500 hover:underline ml-2"><i class="fas fa-trash"></i></button>
</form>
