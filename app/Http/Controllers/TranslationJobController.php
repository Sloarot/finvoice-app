<?php

namespace App\Http\Controllers;

use App\Models\TranslationJob;
use Illuminate\Http\Request;

class TranslationJobController extends Controller
{
    public function index()
    {
        $jobs = TranslationJob::with('client')->latest()->paginate(10);
        return view('translation-jobs.index', compact('jobs'));
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
            'po_number' => 'required|string|unique:translation_jobs,po_number',
            'service' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'deadline' => 'required|date|after_or_equal:today',
            'client_id' => 'required|exists:clients,id',
        ]);

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
            'po_number' => 'required|string|unique:translation_jobs,po_number,' . $translation_job->id,
            'service' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'total_price' => 'required|numeric|min:0',
            'vat' => 'nullable|numeric|min:0',
            'deadline' => 'required|date|after_or_equal:today',
            'client_id' => 'required|exists:clients,id',
        ]);

        $translation_job->update($validated);
        return redirect()->route('translation-jobs.index')->with('success', 'Translation job updated successfully!');
    }

    /**
     * Remove the specified translation job from storage.
     */
    public function destroy(TranslationJob $job)
    {
        $job->delete();
        return redirect()->route('translation-jobs.index')->with('success', 'Translation job deleted successfully!');
    }
}
