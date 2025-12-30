@extends('components.layout')

@section('title', 'Translation Jobs')
@section('page_title', 'Translation Jobs Overview')

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
