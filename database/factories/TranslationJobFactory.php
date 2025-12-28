<?php

namespace Database\Factories;

use App\Models\TranslationJob;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationJobFactory extends Factory
{
    protected $model = TranslationJob::class;

    public function definition(): array
    {
        return [
            'po_number'    => strtoupper($this->faker->bothify('PO-####-???')),
            'service'      => $this->faker->randomElement(['Translation EN-NL', 'Translation FR-NL', 'Translation DE-EN']),
            'title'        => $this->faker->sentence(6),
            'quantity'     => $this->faker->numberBetween(1, 12500),
            'price'        => $this->faker->randomFloat(2, 20, 200),
            'vat'          => $this->faker->randomFloat(2, 0, 40),
            'total_price'  => $this->faker->randomFloat(2, 0, 4000),
            'deadline'     => $this->faker->dateTimeBetween('now', '+1 year'),
            'completed_at' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'client_id'    => Client::factory(),
        ];
    }
}
