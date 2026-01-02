<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $invoiceNet = $this->faker->randomFloat(2, 500, 5000);
        $invoiceVat = $invoiceNet * 0.21; // 21% VAT
        $invoiceTotal = $invoiceNet + $invoiceVat;

        return [
            'client_id' => Client::factory(),
            'invoice_number' => 'INV-' . $this->faker->unique()->numberBetween(10000, 99999),
            'invoice_net' => $invoiceNet,
            'invoice_vat' => $invoiceVat,
            'invoice_total' => $invoiceTotal,
            'due_date' => $this->faker->dateTimeBetween('now', '+60 days'),
            'extra_info' => $this->faker->optional(0.3)->paragraph(),
        ];
    }
}
