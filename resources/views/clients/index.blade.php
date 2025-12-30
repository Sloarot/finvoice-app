@extends('components.layout')

@section('title', 'Clients')
@section('page_title', 'Clients Overview')

@section('content')
    <x-table
        :headers="['Client Name', 'Address', 'City', 'Contact Person', 'Invoice Email', 'Country', 'Actions']"
        :rows="$clients->map(fn($client) => [
            $client->client_name,
            $client->client_address,
            $client->city,
            $client->contact_person,
            $client->invoice_email,
            $client->country,
            view('clients.actions', ['client' => $client])->render()
        ])"
    />

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $clients->links() }}
    </div>

    {{-- New Client Button --}}
    <div class="mt-4">
        <a href="{{ route('clients.create') }}" class="bg-[#702963] text-white px-4 py-2 rounded hover:bg-[#5a1f4f]">New Client</a>
    </div>
@endsection
