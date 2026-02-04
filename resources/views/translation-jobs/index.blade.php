@extends('components.layout')

@section('title', 'Translation Jobs')

@section('header-left')
    <div class="border-2 border-[#702963] text-gray-900 px-5 py-2 rounded-lg font-semibold">
        <span class="text-sm uppercase text-[#702963]">Total Jobs This Month:</span>
        <span class="text-xl ml-2 text-[#702963]">€{{ number_format($monthlyTotal, 2) }}</span>
    </div>
@endsection

@section('content')
    <x-table
        :headers="['PO#', 'Client', 'Service', 'Job Title', 'Price', 'VAT', 'Total Price','Deadline', 'Completion', 'Actions']"
        :rows="$jobs->map(fn($job) => [
            $job->po_number,
            $job->client->client_name,
            $job->service,
            $job->title,
            '€' . number_format($job->price, 2),
            '€' . number_format($job->vat, 2),
             '€' . number_format($job->total_price, 2),
            $job->deadline,
            $job->completed_at ?? '—',
            view('translation-jobs.actions', ['job' => $job])->render()
        ])"
        :sortable="[0, 1, 2, 3, 4, 5, 6, 7, 8]"
    />


    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('sortable-table');
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const headers = table.querySelectorAll('th[data-sort-index]');
    let currentSort = { index: null, direction: 'asc' };

    // Helper function to extract sortable value
    function getSortValue(cell, colIndex) {
        const text = cell.textContent.trim();

        // Currency (€)
        if (text.startsWith('€')) {
            return parseFloat(text.replace('€', '').replace(',', '')) || 0;
        }

        // Date (YYYY-MM-DD format)
        if (/^\d{4}-\d{2}-\d{2}/.test(text)) {
            return new Date(text).getTime();
        }

        // Number
        if (!isNaN(text) && text !== '') {
            return parseFloat(text);
        }

        // String (case-insensitive)
        return text.toLowerCase();
    }

    // Sort function
    function sortTable(colIndex) {
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Toggle direction if same column
        if (currentSort.index === colIndex) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.index = colIndex;
            currentSort.direction = 'asc';
        }

        // Sort rows
        rows.sort((a, b) => {
            const aCell = a.children[colIndex];
            const bCell = b.children[colIndex];

            const aVal = getSortValue(aCell, colIndex);
            const bVal = getSortValue(bCell, colIndex);

            if (aVal === bVal) return 0;

            if (currentSort.direction === 'asc') {
                return aVal > bVal ? 1 : -1;
            } else {
                return aVal < bVal ? 1 : -1;
            }
        });

        // Reorder DOM
        rows.forEach(row => tbody.appendChild(row));

        // Update arrow indicators
        updateArrows();
    }

    // Update visual arrow indicators
    function updateArrows() {
        headers.forEach(header => {
            const arrows = header.querySelectorAll('.sort-arrow');
            const sortIndex = parseInt(header.dataset.sortIndex);

            if (sortIndex === currentSort.index) {
                arrows[0].style.opacity = currentSort.direction === 'asc' ? '1' : '0.3';
                arrows[1].style.opacity = currentSort.direction === 'desc' ? '1' : '0.3';
            } else {
                arrows[0].style.opacity = '0.3';
                arrows[1].style.opacity = '0.3';
            }
        });
    }

    // Add click listeners
    headers.forEach(header => {
        header.addEventListener('click', function() {
            const sortIndex = parseInt(this.dataset.sortIndex);
            sortTable(sortIndex);
        });
    });
});
</script>
@endpush
