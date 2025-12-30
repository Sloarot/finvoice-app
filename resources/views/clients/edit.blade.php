@extends('components.layout')

@section('title', 'Edit Client')

@section('content')
<div class="max-w-4xl mx-auto py-6">

    <form action="{{ route('clients.update', $client) }}" method="POST" class="bg-white shadow-md rounded-lg p-8">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Client Name -->
        <div>
            <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">Client Name</label>
            <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $client->client_name) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('client_name') <span class="text-red-500">{{ $errors->first('client_name') }}</span> @enderror
        </div>

        <!-- Contact Person -->
        <div>
            <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
            <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $client->contact_person) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('contact_person') <span class="text-red-500">{{ $errors->first('contact_person') }}</span> @enderror
        </div>

        <!-- Client Address -->
        <div class="md:col-span-2">
            <label for="client_address" class="block text-sm font-medium text-gray-700 mb-2">Client Address</label>
            <textarea name="client_address" id="client_address"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                rows="3" required>{{ old('client_address', $client->client_address) }}</textarea>
            @error('client_address') <span class="text-red-500">{{ $errors->first('client_address') }}</span> @enderror
        </div>

        <!-- Postal Code -->
        <div>
            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $client->postal_code) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('postal_code') <span class="text-red-500">{{ $errors->first('postal_code') }}</span> @enderror
        </div>

        <!-- City -->
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
            <input type="text" name="city" id="city" value="{{ old('city', $client->city) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('city') <span class="text-red-500">{{ $errors->first('city') }}</span> @enderror
        </div>

        <!-- Invoice Email -->
        <div>
            <label for="invoice_email" class="block text-sm font-medium text-gray-700 mb-2">Invoice Email</label>
            <input type="email" name="invoice_email" id="invoice_email" value="{{ old('invoice_email', $client->invoice_email) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('invoice_email') <span class="text-red-500">{{ $errors->first('invoice_email') }}</span> @enderror
        </div>

        <!-- Country -->
        <div>
            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
            <input type="text" name="country" id="country" value="{{ old('country', $client->country) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4"
                required>
            @error('country') <span class="text-red-500">{{ $errors->first('country') }}</span> @enderror
        </div>

        <!-- VAT Number -->
        <div>
            <label for="vat_number" class="block text-sm font-medium text-gray-700 mb-2">VAT Number</label>
            <input type="text" name="vat_number" id="vat_number" value="{{ old('vat_number', $client->vat_number) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4">
            @error('vat_number') <span class="text-red-500">{{ $errors->first('vat_number') }}</span> @enderror
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-[#702963] text-white px-6 py-2 rounded hover:bg-[#5a1f4f]">Save Client</button>
    </div>

    </form>
</div>
@endsection
