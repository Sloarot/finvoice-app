@extends('components.layout')

@section('title', 'Invoices')
@section('page_title', 'Invoices Overview')

@section('content')
    <x-table
        :headers="['Invoice Number', 'Client', 'Net Amount', 'VAT', 'Total', 'Due Date', 'Actions']"
        :rows="$invoices->map(fn($invoice) => [
            $invoice->invoice_number,
            $invoice->client->client_name,
            '€' . number_format($invoice->invoice_net, 2),
            '€' . number_format($invoice->invoice_vat, 2),
            '€' . number_format($invoice->invoice_total, 2),
            $invoice->due_date->format('Y-m-d'),
            view('invoices.actions', ['invoice' => $invoice])->render()
        ])"
    />

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $invoices->links() }}
    </div>

    {{-- New Invoice Button --}}
    <div class="mt-4">
        <a href="{{ route('invoices.preview') }}" class="bg-[#702963] text-white px-4 py-2 rounded hover:bg-[#5a1f4f]">New Invoice</a>
    </div>
@endsection
