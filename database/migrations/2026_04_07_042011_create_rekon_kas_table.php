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

            $table->bigInteger('opening_cash')->default(0);
            $table->bigInteger('cash_income')->default(0);
            $table->bigInteger('non_cash_income')->default(0);
            $table->bigInteger('operational_cash')->default(0);

            $table->bigInteger('cash_expected')->default(0);
            $table->bigInteger('actual_cash')->default(0);
            $table->bigInteger('difference')->default(0);

            $table->enum('status', ['sesuai', 'selisih kurang', 'selisih lebih'])
                ->default('sesuai');

            $table->text('notes')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->index('rekon_date');
            $table->index('status');
            $table->index('created_by');
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