@extends('components.layout')

@section('title', 'Create Invoice')

@section('content')
<div class="max-w-6xl mx-auto py-6">

    <form action="{{ route('invoices.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-8">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Client -->
        <div class="md:col-span-2">
            <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Client</label>
            <select name="client_id" id="client_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
                <option value="">Select a client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->client_name }}
                    </option>
                @endforeach
            </select>
            @error('client_id') <span class="text-red-500">{{ $errors->first('client_id') }}</span> @enderror
        </div>

        <!-- Invoice Number -->
        <div>
            <label for="invoice_number" class="block text-sm font-medium text-gray-700 mb-2">Invoice Number</label>
            <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('invoice_number') <span class="text-red-500">{{ $errors->first('invoice_number') }}</span> @enderror
        </div>

        <!-- Due Date -->
        <div>
            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('due_date') <span class="text-red-500">{{ $errors->first('due_date') }}</span> @enderror
        </div>

        <!-- Invoice Net -->
        <div>
            <label for="invoice_net" class="block text-sm font-medium text-gray-700 mb-2">Net Amount (€)</label>
            <input type="number" name="invoice_net" id="invoice_net" value="{{ old('invoice_net') }}" step="0.01" min="0"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('invoice_net') <span class="text-red-500">{{ $errors->first('invoice_net') }}</span> @enderror
        </div>

        <!-- Invoice VAT -->
        <div>
            <label for="invoice_vat" class="block text-sm font-medium text-gray-700 mb-2">VAT Amount (€)</label>
            <input type="number" name="invoice_vat" id="invoice_vat" value="{{ old('invoice_vat') }}" step="0.01" min="0"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('invoice_vat') <span class="text-red-500">{{ $errors->first('invoice_vat') }}</span> @enderror
        </div>

        <!-- Invoice Total -->
        <div>
            <label for="invoice_total" class="block text-sm font-medium text-gray-700 mb-2">Total Amount (€)</label>
            <input type="number" name="invoice_total" id="invoice_total" value="{{ old('invoice_total') }}" step="0.01" min="0"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('invoice_total') <span class="text-red-500">{{ $errors->first('invoice_total') }}</span> @enderror
        </div>

        <!-- Extra Info -->
        <div class="md:col-span-2">
            <label for="extra_info" class="block text-sm font-medium text-gray-700 mb-2">Extra Information</label>
            <textarea name="extra_info" id="extra_info"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                rows="3">{{ old('extra_info') }}</textarea>
            @error('extra_info') <span class="text-red-500">{{ $errors->first('extra_info') }}</span> @enderror
        </div>

        <!-- Translation Jobs Selection -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Translation Jobs</label>
            <div class="border rounded-md p-4 max-h-64 overflow-y-auto">
                @forelse($translationJobs as $job)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" name="translation_jobs[]" value="{{ $job->id }}"
                            id="job_{{ $job->id }}"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            {{ in_array($job->id, old('translation_jobs', [])) ? 'checked' : '' }}>
                        <label for="job_{{ $job->id }}" class="ml-2 text-sm text-gray-700">
                            {{ $job->po_number }} - {{ $job->title }} ({{ $job->client->client_name }}) - €{{ number_format($job->total_price, 2) }}
                        </label>
                    </div>
                @empty
                    <p class="text-gray-500">No available translation jobs</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end mt-6">
        <a href="{{ route('invoices.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 mr-2">Cancel</a>
        <button type="submit" class="bg-[#702963] text-white px-6 py-2 rounded hover:bg-[#5a1f4f]">Create Invoice</button>
    </div>

    </form>
</div>
@endsection
