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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('original_price'); // Menggunakan string karena ada yang bernilai 'Custom'
            $table->integer('discount_percent')->default(0);
            $table->string('period')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('badge')->nullable();
            $table->string('button_text');
            $table->json('features');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
