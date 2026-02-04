@props(['headers', 'rows', 'sortable' => []])

<table class="w-full table-auto border-collapse" id="sortable-table">
    <thead class="bg-[#702963] text-white">
        <tr>
            @foreach($headers as $index => $header)
                <th class="p-3 text-left {{ in_array($index, $sortable) ? 'cursor-pointer select-none hover:bg-[#8a3477] transition-colors' : '' }}"
                    @if(in_array($index, $sortable)) data-sort-index="{{ $index }}" @endif>
                    <div class="flex items-center gap-2">
                        <span>{{ $header }}</span>
                        @if(in_array($index, $sortable))
                            <div class="flex flex-col text-xs leading-none">
                                <span class="sort-arrow sort-asc opacity-30">▲</span>
                                <span class="sort-arrow sort-desc opacity-30">▼</span>
                            </div>
                        @endif
                    </div>
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
       @foreach($rows as $row)
    <tr>
        @foreach($row as $index => $cell)
            <td class="px-2 py-2">
                @if($index === count($headers) - 1 || $index === 5)
                    {{-- Last column = Actions, Index 5 = Country (with flag) --}}
                    {!! $cell !!}
                @else
                    {{ $cell }}
                @endif
            </td>
        @endforeach
    </tr>
@endforeach
    </tbody>
</table>

