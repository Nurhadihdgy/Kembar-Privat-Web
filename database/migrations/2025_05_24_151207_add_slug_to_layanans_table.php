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
        Schema::table('layanans', function (Blueprint $table) {
            // // Tambahkan kolom slug, buat nullable untuk sementara
            // $table->string('slug')->nullable()->after('nama'); // atau sesuaikan posisi 'after'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            // $table->dropColumn('slug');
        });
    }
};
