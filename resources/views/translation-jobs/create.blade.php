@extends('components.layout')

@section('title', 'Create Translation Job')
@section('page_title', 'Create a New Translation Job')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Create a New Job</h1>
    <form action="{{ route('translation-jobs.store') }}" method="POST" class="...">
    @csrf

    <!-- PO Number -->
    <div>
        <label for="po_number" class="block text-sm font-medium text-gray-700">PO Number</label>
        <input type="text" name="po_number" id="po_number"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required>
    </div>

    <!-- Service -->
    <div>
        <label for="service" class="block text-sm font-medium text-gray-700">Service</label>
        <input type="text" name="service" id="service"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="e.g. Translation EN-NL" required>
    </div>

    <!-- Title -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Job Title</label>
        <input type="text" name="title" id="title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required>
    </div>

    <!-- Price -->
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Price (€)</label>
        <input type="number" step="0.01" name="price" id="price"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required>
    </div>

    <!-- VAT -->
    <div>
        <label for="vat" class="block text-sm font-medium text-gray-700">VAT (€)</label>
        <input type="number" step="0.01" name="vat" id="vat"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            value="0">
    </div>

    <!-- Deadline -->
    <div>
        <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
        <input type="date" name="deadline" id="deadline"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required>
    </div>

    <!-- Client -->
    <div>
        <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
        <select name="client_id" id="client_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Submit -->
    <div class="pt-6 text-right">
        <button type="submit"
            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
            Add Job
        </button>
    </div>
</form>
</div>
@endsection
