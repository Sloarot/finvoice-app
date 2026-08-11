<?php

namespace App\Http\Controllers;

use App\Models\TranslationJob;
use Illuminate\Http\Request;

class TranslationJobController extends Controller
{
    public function index()
    {
        $jobs = TranslationJob::with('client')
            ->where(function ($query) {
                $query->whereNull('is_on_invoice')
                    ->orWhere('is_on_invoice', false);
            })
            ->latest()
            ->paginate(25);

        // Calculate total for current month
        $monthlyTotal = TranslationJob::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        return view('translation-jobs.index', compact('jobs', 'monthlyTotal'));
    }
    /** * Show the form for creating a new translation job. */
    public function create()
    {
        $clients = \App\Models\Client::all();
        return view('translation-jobs.create', compact('clients'));
    }
    /** * Store a newly created translation job in storage. */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'po_number' => 'required|string',
            'service' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'deadline' => 'required|date',
            'client_id' => 'required|exists:clients,id',
        ]);

        // The `vat` column is NOT NULL with a DB-level default of 0 (see the
        // translation_jobs migration), but the validation rule above is
        // `nullable` — leaving the field blank passes validation as `null`,
        // which then fails at the DATABASE level with an uncaught
        // "Column 'vat' cannot be null" query exception instead of the
        // normal inline @error() message. Coalescing here treats a blank
        // VAT field as 0, matching both the DB default and the form's own
        // pre-filled "0" value.
        $validated['vat'] ??= 0;

        TranslationJob::create($validated);
        return redirect()->route('translation-jobs.index')->with('success', 'Translation job created successfully!');
    }

    /**
     * Show the form for editing the specified translation job.
     */
    public function edit(TranslationJob $translation_job)
    {
        $clients = \App\Models\Client::all();
        return view('translation-jobs.edit', compact('translation_job', 'clients'));
    }

    /**
     * Update the specified translation job in storage.
     */
    public function update(Request $request, TranslationJob $translation_job)
    {
        $validated = $request->validate([
            'po_number' => 'required|string',
            'service' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'deadline' => 'required|date',
            'completed_at' => 'nullable|date',
            'client_id' => 'required|exists:clients,id',
        ]);

        // Same "blank VAT means 0" coalescing as store() above — see the
        // comment there.
        $validated['vat'] ??= 0;

        $translation_job->update($validated);
        return redirect()->route('translation-jobs.index')->with('success', 'Translation job updated successfully!');
    }

    /**
     * Remove the specified translation job from storage.
     */
    public function destroy(TranslationJob $translation_job)
    {
        $translation_job->delete();
        return redirect()->route('translation-jobs.index')->with('success', 'Translation job deleted successfully!');
    }
}
