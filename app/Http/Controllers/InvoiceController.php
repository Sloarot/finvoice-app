<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\TranslationJob;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    /**
     * Show the preview page for creating an invoice.
     */
    public function preview()
    {
        $clients = Client::orderBy('client_name')->get();
        $translationJobs = TranslationJob::whereNull('is_on_invoice')
            ->with('client')
            ->orderBy('deadline')
            ->get();

        return view('invoices.preview', compact('clients', 'translationJobs'));
    }

    /**
     * Preview the PDF template in the browser for styling purposes.
     */
    public function pdfPreview()
    {
        // Get a random client with translation jobs
        $client = Client::has('translationJobs')->inRandomOrder()->first();

        if (!$client) {
            return redirect()->route('invoices.index')->with('error', 'No clients with translation jobs found. Please seed the database first.');
        }

        // Get some translation jobs for this client (limit to 10 for preview)
        $translationJobs = TranslationJob::where('client_id', $client->id)
            ->whereNull('is_on_invoice')
            ->orderBy('deadline')
            ->limit(10)
            ->get();

        if ($translationJobs->isEmpty()) {
            return redirect()->route('invoices.index')->with('error', 'No available translation jobs found for preview.');
        }

        // Calculate totals
        $invoiceNet = $translationJobs->sum('total_price');
        $invoiceVat = $invoiceNet * 0.21;
        $invoiceTotal = $invoiceNet + $invoiceVat;

        // Prepare data for PDF preview
        $data = [
            'client' => $client,
            'translationJobs' => $translationJobs,
            'invoiceNumber' => 'INV-2026-PREVIEW',
            'invoiceNet' => $invoiceNet,
            'invoiceVat' => $invoiceVat,
            'invoiceTotal' => $invoiceTotal,
            'extraInfo' => 'This is a preview invoice for styling purposes',
        ];

        // Return the view directly (no PDF generation)
        return view('invoices.pdf', $data);
    }

    /**
     * Generate PDF for the invoice.
     */
    public function generatePdf(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'translation_jobs' => 'required|array|min:1',
            'translation_jobs.*' => 'exists:translation_jobs,id',
            'invoice_net' => 'required|numeric|min:0',
            'invoice_vat' => 'required|numeric|min:0',
            'invoice_total' => 'required|numeric|min:0',
            'extra_info' => 'nullable|string',
        ]);

        // Get client and translation jobs
        $client = Client::findOrFail($request->client_id);
        $translationJobs = TranslationJob::whereIn('id', $request->translation_jobs)
            ->orderBy('deadline')
            ->get();

        // Generate invoice number (format: INV-YYYY-XXXX)
        $year = now()->year;
        $lastInvoice = Invoice::where('invoice_number', 'like', "INV-{$year}-%")
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        $invoiceNumber = "INV-{$year}-{$newNumber}";

        // Prepare data for PDF
        $data = [
            'client' => $client,
            'translationJobs' => $translationJobs,
            'invoiceNumber' => $invoiceNumber,
            'invoiceNet' => $request->invoice_net,
            'invoiceVat' => $request->invoice_vat,
            'invoiceTotal' => $request->invoice_total,
            'extraInfo' => $request->extra_info ?? null,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('invoices.pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        // Set options for better rendering
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
        ]);

        // Display PDF in browser (inline = opens in new tab instead of download)
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice_' . $invoiceNumber . '.pdf"',
        ]);
    }
}
