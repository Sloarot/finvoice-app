@extends('components.layout')

@section('title', 'Invoice Preview')
{{-- @section('page_title', 'Create Invoice - Preview') --}}

@section('content')
<div class="max-w-7xl mx-auto py-6">
    <div class="bg-white shadow-md rounded-lg p-8">

        <!-- Client Selection -->
        <div class="mb-6">
            <label for="client_select" class="block text-sm font-medium text-gray-700 mb-2">
                Select Client
            </label>
            <select id="client_select"
                class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
                <option value="">-- Select a client --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Translation Jobs Table -->
        <div id="jobs-container" class="mb-6 hidden">
            <h3 class="text-lg font-semibold mb-4">Available Translation Jobs</h3>
            <p class="text-sm text-gray-600 mb-4">Select the jobs you want to include in this invoice:</p>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PO Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                        </tr>
                    </thead>
                    <tbody id="jobs-table-body" class="bg-white divide-y divide-gray-200">
                        <!-- Jobs will be loaded here via JavaScript -->
                    </tbody>
                </table>
            </div>

            <div id="no-jobs-message" class="text-gray-500 text-center py-8 hidden">
                No available translation jobs for this client.
            </div>

            <!-- Summary Section -->
            <div id="summary-section" class="mt-6 bg-gray-50 p-4 rounded-md hidden">
                <h4 class="text-md font-semibold mb-2">Invoice Summary</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <span class="text-gray-600">Net Amount:</span>
                        <span class="font-semibold ml-2">€<span id="summary-net">0.00</span></span>
                    </div>
                    <div>
                        <span class="text-gray-600">VAT:</span>
                        <span class="font-semibold ml-2">€<span id="summary-vat">0.00</span></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Total:</span>
                        <span class="font-semibold ml-2 text-lg">€<span id="summary-total">0.00</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mt-8">
            <a href="{{ route('invoices.index') }}"
                class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                Cancel
            </a>
            <button id="save-pdf-btn"
                class="bg-[#702963] text-white px-6 py-2 rounded hover:bg-[#5a1f4f] disabled:bg-gray-400 disabled:cursor-not-allowed"
                disabled>
                Save PDF
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const translationJobs = @json($translationJobs);
    const clientSelect = document.getElementById('client_select');
    const jobsContainer = document.getElementById('jobs-container');
    const jobsTableBody = document.getElementById('jobs-table-body');
    const noJobsMessage = document.getElementById('no-jobs-message');
    const selectAllCheckbox = document.getElementById('select-all');
    const savePdfBtn = document.getElementById('save-pdf-btn');
    const summarySection = document.getElementById('summary-section');

    // Filter and display jobs when client is selected
    clientSelect.addEventListener('change', function() {
        const clientId = parseInt(this.value);

        if (!clientId) {
            jobsContainer.classList.add('hidden');
            summarySection.classList.add('hidden');
            savePdfBtn.disabled = true;
            return;
        }

        const clientJobs = translationJobs.filter(job => job.client_id === clientId);

        if (clientJobs.length === 0) {
            jobsContainer.classList.remove('hidden');
            jobsTableBody.innerHTML = '';
            noJobsMessage.classList.remove('hidden');
            summarySection.classList.add('hidden');
            savePdfBtn.disabled = true;
            return;
        }

        noJobsMessage.classList.add('hidden');
        jobsContainer.classList.remove('hidden');

        // Populate table
        jobsTableBody.innerHTML = clientJobs.map(job => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" class="job-checkbox rounded border-gray-300"
                        data-job-id="${job.id}"
                        data-price="${job.price}"
                        data-total="${job.total_price}"
                        data-vat="${job.vat}">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${job.po_number}</td>
                <td class="px-6 py-4 text-sm text-gray-900">${job.title}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${job.service}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${job.quantity}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€${parseFloat(job.price).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€${parseFloat(job.total_price).toFixed(2)}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${new Date(job.deadline).toLocaleDateString()}</td>
            </tr>
        `).join('');

        // Add event listeners to checkboxes
        document.querySelectorAll('.job-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSummary);
        });

        updateSummary();
    });

    // Select All functionality
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.job-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSummary();
    });

    // Update summary and button state
    function updateSummary() {
        const selectedCheckboxes = document.querySelectorAll('.job-checkbox:checked');
        const count = selectedCheckboxes.length;

        if (count === 0) {
            summarySection.classList.add('hidden');
            savePdfBtn.disabled = true;
            return;
        }

        let totalNet = 0;
        let totalVat = 0;

        selectedCheckboxes.forEach(checkbox => {
            const price = parseFloat(checkbox.dataset.price);
            const total = parseFloat(checkbox.dataset.total);
            const vat = parseFloat(checkbox.dataset.vat);

            totalNet += price;
            totalVat += (total - price);
        });

        const grandTotal = totalNet + totalVat;

        document.getElementById('summary-net').textContent = totalNet.toFixed(2);
        document.getElementById('summary-vat').textContent = totalVat.toFixed(2);
        document.getElementById('summary-total').textContent = grandTotal.toFixed(2);

        summarySection.classList.remove('hidden');
        savePdfBtn.disabled = false;
    }

    // Save PDF button handler
    savePdfBtn.addEventListener('click', function() {
        const clientId = parseInt(clientSelect.value);
        const selectedJobs = Array.from(document.querySelectorAll('.job-checkbox:checked'))
            .map(cb => cb.dataset.jobId);

        if (!clientId || selectedJobs.length === 0) {
            alert('Please select a client and at least one translation job.');
            return;
        }

        // Get summary values
        const net = parseFloat(document.getElementById('summary-net').textContent);
        const vat = parseFloat(document.getElementById('summary-vat').textContent);
        const total = parseFloat(document.getElementById('summary-total').textContent);

        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("invoices.generatePdf") }}';

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add client_id
        const clientInput = document.createElement('input');
        clientInput.type = 'hidden';
        clientInput.name = 'client_id';
        clientInput.value = clientId;
        form.appendChild(clientInput);

        // Add translation jobs
        selectedJobs.forEach(jobId => {
            const jobInput = document.createElement('input');
            jobInput.type = 'hidden';
            jobInput.name = 'translation_jobs[]';
            jobInput.value = jobId;
            form.appendChild(jobInput);
        });

        // Add totals
        ['net', 'vat', 'total'].forEach(field => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `invoice_${field}`;
            input.value = field === 'net' ? net : field === 'vat' ? vat : total;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    });
</script>
@endpush
@endsection
