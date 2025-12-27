@extends('components.layout')

@section('title', 'Create Translation Job')
@section('page_title', 'Create a New Translation Job')

@section('content')
<div class="max-w-4xl mx-auto py-6">

    <form action="{{ route('translation-jobs.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-8 space-y-3">
    @csrf

    <!-- Client -->
    <div>
        <label for="client_id" class="block text-sm font-medium text-gray-700 mb-2">Client</label>
        <select name="client_id" id="client_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>


    <!-- Service -->
    <div>
        <label for="service" class="block text-sm font-medium text-gray-700 mb-2">Service</label>
        <select name="service" id="service"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
            <option value="Translation FR-NL">Translation FR-NL</option>
             <option value="Revision FR-NL">Revision FR-NL</option>
            <option selected value="Translation EN-NL">Translation EN-NL</option>
            <option  value="Revision EN-NL">Revision EN-NL</option>

            <option value="Translation ES-NL">Translation ES-NL</option>
            <option value="Revision ES-NL">Revision ES-NL</option>
            <option value="PEMT FR-NL">PEMT FR-NL</option>
            <option value="PEMT EN-NL">PEMT EN-NL</option>
            <option value="Translation PT-NL">Translation PT-NL</option>
            <option value="Revision PT-NL">Revision PT-NL</option>
        </select>
    </div>

     <!-- PO Number -->
    <div>
        <label for="po_number" class="block text-sm font-medium text-gray-700 mb-2">PO Number</label>
        <input type="text" name="po_number" id="po_number"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
    </div>


    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
        <input type="text" name="title" id="title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
            required>
    </div>

    <!-- Pricing and Deadline Section -->
    <div class="flex space-x-6">
        <!-- Pricing Fields -->
        <div class="flex-1 space-y-4">
            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <div class="relative">
                    <input type="number" step="0.01" name="price" id="price"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 pr-8"
                        required>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">€</span>
                </div>
            </div>

            <!-- VAT -->
            <div>
                <label for="vat" class="block text-sm font-medium text-gray-700 mb-2">VAT</label>
                <div class="relative">
                    <input type="number" step="0.01" name="vat" id="vat"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 pr-8"
                        value="0">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">€</span>
                </div>
            </div>

            <!-- Job Total -->
            <div>
                <label for="total_price" class="block text-sm font-medium text-gray-700 mb-2">Job Total</label>
                <div class="relative">
                    <input type="number" step="0.01" name="total_price" id="total_price"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 pr-8">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">€</span>
                </div>
            </div>
        </div>

        <!-- Deadline -->
        <div class="flex-1">
            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
            <input type="date" name="deadline" id="deadline"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3"
                required>
        </div>
    </div>



    <!-- Submit -->
    <div class="pt-6 text-right">
        <button type="submit"
            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
            Add Job
        </button>
    </div>
</form>
   <!-- Calculator -->
    <div class="border-t pt-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Price Calculator</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="po_amount" class="block text-sm font-medium text-gray-700 mb-2">PO Amount</label>
                <input type="number" id="po_amount" min="0"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
            </div>
            <div>
                <label for="rate" class="block text-sm font-medium text-gray-700 mb-2">Rate per Word (€)</label>
                <select id="rate"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
                    <option value="0.09">0.09</option>
                    <option value="0.10">0.10</option>
                    <option value="0.11" selected>0.11</option>
                    <option value="0.12">0.12</option>
                    <option value="0.13">0.13</option>
                    <option value="0.14">0.14</option>
                </select>
            </div>
            <div>
                <label for="result" class="block text-sm font-medium text-gray-700 mb-2">Total Price (€)</label>
                <input type="number" step="0.01" id="result" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-50 p-4">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const PoInput = document.getElementById('po_amount');
    const rateSelect = document.getElementById('rate');
    const resultInput = document.getElementById('result');

    function calculate() {
        const amount = parseFloat(PoInput.value) || 0;
        const rate = parseFloat(rateSelect.value);
        const total = amount / rate;
        resultInput.value = total.toFixed(2);
    }

    PoInput.addEventListener('input', calculate);
    rateSelect.addEventListener('change', calculate);
});
</script>
@endsection
