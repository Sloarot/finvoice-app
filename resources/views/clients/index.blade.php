@extends('components.layout')

@section('title', 'Clients')

@section('content')
    <x-table
        :headers="['Client Name', 'Address', 'City', 'Contact Person', 'Invoice Email', 'Country', 'Actions']"
        :rows="$clients->map(function($client) {
            $flagCode = $client->getCountryFlagCode();
            $countryDisplay = $flagCode
                ? '<span class=\'fi fi-' . $flagCode . '\' style=\'font-size: 2em;\'></span>'
                : e($client->country);

            return [
                $client->client_name,
                $client->client_address,
                $client->city,
                $client->contact_person,
                $client->invoice_email,
                $countryDisplay,
                view('clients.actions', ['client' => $client])->render()
            ];
        })"
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
