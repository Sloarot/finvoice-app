<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    /**
     * Display the charts view
     */
    public function index()
    {
        return view('charts');
    }

    /**
     * Get monthly invoice totals for bar chart (all 12 months per year)
     */
    public function monthlyInvoices()
    {
        // Get all years that have invoices
        $years = Invoice::selectRaw('DISTINCT YEAR(created_at) as year')
            ->orderBy('year', 'asc')
            ->pluck('year');

        // Get actual invoice data
        $invoiceData = Invoice::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(invoice_total) as total')
        )
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . $item->month;
            });

        $labels = [];
        $data = [];

        // Create data for all 12 months of each year
        foreach ($years as $year) {
            for ($month = 1; $month <= 12; $month++) {
                $key = $year . '-' . $month;
                $labels[] = date('M Y', mktime(0, 0, 0, $month, 1, $year));
                $data[] = isset($invoiceData[$key]) ? (float) $invoiceData[$key]->total : 0;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    /**
     * Get total invoiced amount for current year
     */
    public function yearlyTotal()
    {
        $currentYear = date('Y');
        $total = Invoice::whereYear('created_at', $currentYear)
            ->sum('invoice_total');

        return response()->json([
            'year' => $currentYear,
            'total' => (float) $total
        ]);
    }

    /**
     * Get all clients by invoice total for pie chart
     */
    public function topClients()
    {
        $topClients = Client::select('clients.id', 'clients.client_name', DB::raw('SUM(invoices.invoice_total) as total'))
            ->join('invoices', 'clients.id', '=', 'invoices.client_id')
            ->groupBy('clients.id', 'clients.client_name')
            ->orderBy('total', 'desc')
            ->get();

        $labels = $topClients->pluck('client_name');
        $data = $topClients->pluck('total')->map(fn($value) => (float) $value);

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}
