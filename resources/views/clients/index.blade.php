@extends('components.layout')

@section('title', 'Clients')
@section('page_title', 'Clients Overview')

@section('content')
    <x-table
        :headers="['Name', 'Email', 'Company', 'VAT Number', 'Actions']"
        :rows="$clients->map(fn($client) => [
            $client->name,
            $client->email,
            $client->company ?? '—',
            $client->vat_number ?? '—',
            view('clients.actions', ['client' => $client])->render()
        ])"
    />

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $clients->links() }}
    </div>
@endsection
