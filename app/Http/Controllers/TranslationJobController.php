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
            'deadline' => 'required|date|after:today',
            'client_id' => 'required|exists:clients,id',
        ]);

        TranslationJob::create($validated);
        return redirect()->route('translation-jobs.index')->with('success', 'Translation job created successfully!');
    }
}
