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
            <td class="px-3 py-2">
                @if($index === count($headers) - 1)
                    {{-- Last column = Actions --}}
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
