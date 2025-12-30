<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'invoice_email' => 'required|email|unique:clients,invoice_email',
            'vat_number' => 'nullable|string|max:50',
            'contact_person' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_address' => 'required|string',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'invoice_email' => 'required|email|unique:clients,invoice_email,' . $client->id,
            'vat_number' => 'nullable|string|max:50',
            'contact_person' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
