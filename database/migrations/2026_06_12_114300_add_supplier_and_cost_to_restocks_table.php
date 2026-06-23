<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restocks', function (Blueprint $table) {
            $table->unsignedBigInteger('supplier_id')->nullable()->after('medicine_id');
            $table->decimal('cost_price', 15, 2)->default(0)->after('quantity');
            $table->decimal('total_cost', 15, 2)->default(0)->after('cost_price');

            $table->foreign('supplier_id')
                ->references('id')->on('suppliers')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('restocks', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['supplier_id', 'cost_price', 'total_cost']);
        });
    }
};
