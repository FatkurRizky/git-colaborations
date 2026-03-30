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
        Schema::create('rekon_kas', function (Blueprint $table) {
            $table->id();
            $table->date('rekon_date');
            $table->decimal('opening_cash', 15, 2)->default(0);
            $table->decimal('cash_income', 15, 2)->default(0);
            $table->decimal('non_cash_income', 15, 2)->default(0);
            $table->decimal('operational_cash', 15, 2)->default(0);
            $table->decimal('cash_expected', 15, 2)->default(0);
            $table->decimal('actual_cash', 15, 2)->default(0);
            $table->decimal('difference', 15, 2)->default(0);
            $table->enum('status', ['match', 'selisih kurang', 'selisih lebih'])->default('match');
            $table->text('notes')->nullable();

            // HAPUS baris $table->bigInteger('created_by') jika ada.
            // CUKUP pakai satu baris ini saja:
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekon_kas');
    }
};
