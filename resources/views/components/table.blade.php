@props(['headers', 'rows'])

<table class="w-full table-auto border-collapse">
    <thead class="bg-[#702963] text-white">
        <tr>
            @foreach($headers as $header)
                <th class="p-3 text-left">{{ $header }}</th>
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
