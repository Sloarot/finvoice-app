<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\TranslationJob;
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

        /// Seed 25 clients
        $clients = Client::factory()->count(25)->create();

        // Seed 200 translation jobs linked to random clients
        TranslationJob::factory()->count(200)->make()->each(function ($job) use ($clients) {
            $job->client_id = $clients->random()->id;
            $job->save();
        });
    }
}
