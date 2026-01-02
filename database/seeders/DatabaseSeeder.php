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

        // Seed 25 clients
        $clients = Client::factory()->count(25)->create();

        // Seed 200 translation jobs linked to random clients
        $translationJobs = TranslationJob::factory()->count(200)->make()->map(function ($job) use ($clients) {
            $job->client_id = $clients->random()->id;
            $job->save();
            return $job;
        });

        // Create 20 invoices and assign 10% of translation jobs to them
        $invoiceCount = 20;
        $jobsToInvoice = $translationJobs->random((int) ($translationJobs->count() * 0.1));

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
