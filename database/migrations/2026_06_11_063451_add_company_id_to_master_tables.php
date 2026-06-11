<?php

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('slug');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('name');
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('unit_id');
        });

        $owner = User::first(); 
        
        if ($owner) {
            $company = Company::firstOrCreate(
                ['owner_id' => $owner->id],
                ['name' => 'Apotek ' . $owner->name]
            );

            DB::table('categories')->whereNull('company_id')->update(['company_id' => $company->id]);
            DB::table('units')->whereNull('company_id')->update(['company_id' => $company->id]);
            DB::table('medicines')->whereNull('company_id')->update(['company_id' => $company->id]);
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('company_id', 'fk_categories_company_id')
                  ->references('id')->on('companies')->cascadeOnDelete();
        });

        Schema::table('units', function (Blueprint $table) {
            $table->foreign('company_id', 'fk_units_company_id')
                  ->references('id')->on('companies')->cascadeOnDelete();
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->foreign('company_id', 'fk_medicines_company_id')
                  ->references('id')->on('companies')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('fk_categories_company_id');
            $table->dropColumn('company_id');
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign('fk_units_company_id');
            $table->dropColumn('company_id');
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign('fk_medicines_company_id');
            $table->dropColumn('company_id');
        });
    }
};