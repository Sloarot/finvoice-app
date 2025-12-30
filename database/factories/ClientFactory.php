<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->company(),
            'client_address' => $this->faker->address(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'invoice_email' => $this->faker->unique()->safeEmail(),
            'vat_number' => strtoupper($this->faker->bothify('VAT-####-???')),
            'contact_person' => $this->faker->name(),
            'country' => $this->faker->country(),
        ];
    }
}
