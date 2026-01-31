@extends('components.layout')

@section('title', 'Translation Jobs')

@section('header-left')
    <div class="border-2 border-[#702963] text-gray-900 px-5 py-2 rounded-lg font-semibold">
        <span class="text-sm uppercase text-[#702963]">Total Jobs This Month:</span>
        <span class="text-xl ml-2 text-[#702963]">€{{ number_format($monthlyTotal, 2) }}</span>
    </div>
@endsection

@section('content')
    <x-table
        :headers="['PO#', 'Client', 'Service', 'Job Title', 'Price', 'VAT', 'Total Price','Deadline', 'Completion', 'Actions']"
        :rows="$jobs->map(fn($job) => [
            $job->po_number,
            $job->client->client_name,
            $job->service,
            $job->title,
            '€' . number_format($job->price, 2),
            '€' . number_format($job->vat, 2),
             '€' . number_format($job->total_price, 2),
            $job->deadline,
            $job->completed_at ?? '—',
            view('translation-jobs.actions', ['job' => $job])->render()
        ])"
    />


    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
@endsection
