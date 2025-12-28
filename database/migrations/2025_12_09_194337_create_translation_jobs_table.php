<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translation_jobs', function (Blueprint $table) {
            $table->id();


            $table->string('po_number')->unique();
            $table->string('service');
            $table->string('title');
            $table->decimal('quantity', 8, 2);
            $table->decimal('price', 8, 2);
            $table->decimal('vat', 8, 2)->default(0);
            $table->decimal('total_price', 8, 2)->default(0);
            $table->date('deadline');
            $table->date('completed_at')->nullable();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translation_jobs');
    }
};
