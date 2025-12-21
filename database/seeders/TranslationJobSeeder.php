<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TranslationJob;

class TranslationJobSeeder extends Seeder
{
    public function run(): void
    {
        TranslationJob::factory()->count(200)->create();
    }
}
