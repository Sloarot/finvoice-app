@extends('components.layout')

@section('title', 'Invoice Details')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <div class="bg-white shadow-md rounded-lg p-8">
        <!-- Invoice Header -->
        <div class="border-b pb-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Invoice #{{ $invoice->invoice_number }}</h2>
            <p class="text-gray-600">Created: {{ $invoice->created_at->format('Y-m-d H:i') }}</p>
        </div>

        <!-- Invoice Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Client Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Client Information</h3>
                <div class="space-y-2">
                    <p><strong>Name:</strong> {{ $invoice->client->client_name }}</p>
                    <p><strong>Address:</strong> {{ $invoice->client->client_address }}</p>
                    <p><strong>City:</strong> {{ $invoice->client->city }}, {{ $invoice->client->postal_code }}</p>
                    <p><strong>Country:</strong> {{ $invoice->client->country }}</p>
                    <p><strong>Email:</strong> {{ $invoice->client->invoice_email }}</p>
                    @if($invoice->client->vat_number)
                        <p><strong>VAT Number:</strong> {{ $invoice->client->vat_number }}</p>
                    @endif
                </div>
            </div>

            <!-- Invoice Amounts -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Invoice Amounts</h3>
                <div class="space-y-2">
                    <p><strong>Net Amount:</strong> €{{ number_format($invoice->invoice_net, 2) }}</p>
                    <p><strong>VAT Amount:</strong> €{{ number_format($invoice->invoice_vat, 2) }}</p>
                    <p class="text-xl font-bold text-[#702963]"><strong>Total Amount:</strong> €{{ number_format($invoice->invoice_total, 2) }}</p>
                    <p><strong>Due Date:</strong> {{ $invoice->due_date->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>

        <!-- Extra Information -->
        @if($invoice->extra_info)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Additional Information</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $invoice->extra_info }}</p>
            </div>
        @endif

        <!-- Translation Jobs -->
        @if($invoice->translationJobs->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Translation Jobs on this Invoice</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PO Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($invoice->translationJobs as $job)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $job->po_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $job->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $job->service }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $job->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€{{ number_format($job->price, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">€{{ number_format($job->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t">
            <a href="{{ route('invoices.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Back to List</a>
            <a href="{{ route('invoices.edit', $invoice) }}" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">Edit Invoice</a>
            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this invoice?')">Delete Invoice</button>
            </form>
        </div>
    </div>
</div>
@endsection
