<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\TranslationJob;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('client')->latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('client_name')->get();
        $translationJobs = TranslationJob::whereNull('is_on_invoice')
            ->with('client')
            ->orderBy('deadline')
            ->get();

        return view('invoices.create', compact('clients', 'translationJobs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number',
            'invoice_net' => 'required|numeric|min:0',
            'invoice_vat' => 'required|numeric|min:0',
            'invoice_total' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'extra_info' => 'nullable|string',
            'translation_jobs' => 'nullable|array',
            'translation_jobs.*' => 'exists:translation_jobs,id',
        ]);

        $invoice = Invoice::create($request->except('translation_jobs'));

        // Update translation jobs if provided
        if ($request->has('translation_jobs')) {
            TranslationJob::whereIn('id', $request->translation_jobs)
                ->update([
                    'invoice_id' => $invoice->id,
                    'is_on_invoice' => true,
                ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('client', 'translationJobs');
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('client_name')->get();
        $translationJobs = TranslationJob::where(function ($query) use ($invoice) {
            $query->whereNull('is_on_invoice')
                ->orWhere('invoice_id', $invoice->id);
        })
            ->with('client')
            ->orderBy('deadline')
            ->get();

        $invoice->load('translationJobs');

        return view('invoices.edit', compact('invoice', 'clients', 'translationJobs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|max:255|unique:invoices,invoice_number,' . $invoice->id,
            'invoice_net' => 'required|numeric|min:0',
            'invoice_vat' => 'required|numeric|min:0',
            'invoice_total' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'extra_info' => 'nullable|string',
            'translation_jobs' => 'nullable|array',
            'translation_jobs.*' => 'exists:translation_jobs,id',
        ]);

        $invoice->update($request->except('translation_jobs'));

        // Reset previous translation jobs
        TranslationJob::where('invoice_id', $invoice->id)
            ->update([
                'invoice_id' => null,
                'is_on_invoice' => null,
            ]);

        // Update translation jobs if provided
        if ($request->has('translation_jobs')) {
            TranslationJob::whereIn('id', $request->translation_jobs)
                ->update([
                    'invoice_id' => $invoice->id,
                    'is_on_invoice' => (int) str_replace('INV-', '', $invoice->invoice_number),
                ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        // Reset translation jobs before deleting
        TranslationJob::where('invoice_id', $invoice->id)
            ->update([
                'invoice_id' => null,
                'is_on_invoice' => null,
            ]);

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
