<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\TranslationJob;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Database\Seeders\TranslationJobSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed 10-15 clients (we'll do 12 for a good middle ground)
        $clientCount = rand(10, 15);
        $clients = Client::factory()->count($clientCount)->create();

        // For each client, create approximately 50 translation jobs that are NOT on invoices yet
        $allJobs = collect();
        $clients->each(function ($client) use (&$allJobs) {
            // Create 48-52 jobs per client (randomized around 50)
            $jobCount = rand(48, 52);
            $jobs = TranslationJob::factory()->count($jobCount)->create([
                'client_id' => $client->id,
                'invoice_id' => null,
                'is_on_invoice' => null,
            ]);
            $allJobs = $allJobs->merge($jobs);
        });

        // Optionally create a few invoices with some jobs (to show that the system works)
        // But keep most jobs available for invoicing
        $invoiceCount = 5;
        $jobsToInvoice = $allJobs->random(min(50, (int)($allJobs->count() * 0.08))); // Only 8% of jobs

        $invoices = collect();
        for ($i = 0; $i < $invoiceCount; $i++) {
            // Create invoice for a random client
            $client = $clients->random();
            $invoice = Invoice::factory()->create([
                'client_id' => $client->id,
            ]);
            $invoices->push($invoice);
        }

        // Distribute the jobs to invoices
        $jobsToInvoice->each(function ($job) use ($invoices) {
            $invoice = $invoices->random();
            $job->update([
                'invoice_id' => $invoice->id,
                'is_on_invoice' => (int) str_replace('INV-', '', $invoice->invoice_number),
                'client_id' => $invoice->client_id, // Ensure job belongs to the same client as invoice
            ]);
        });

        // Update invoice amounts based on assigned jobs
        $invoices->each(function ($invoice) {
            $jobs = $invoice->translationJobs;
            if ($jobs->count() > 0) {
                $totalNet = $jobs->sum('total_price');
                $totalVat = $totalNet * 0.21;
                $invoice->update([
                    'invoice_net' => $totalNet,
                    'invoice_vat' => $totalVat,
                    'invoice_total' => $totalNet + $totalVat,
                ]);
            }
        });
    }
}
