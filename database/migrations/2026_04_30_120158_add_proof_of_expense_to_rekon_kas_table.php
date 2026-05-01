<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekon_kas', function (Blueprint $table) {
            // Kolom untuk menyimpan nama file struk/nota
            $table->string('proof_of_expense')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('rekon_kas', function (Blueprint $table) {
            $table->dropColumn('proof_of_expense');
        });
    }
};