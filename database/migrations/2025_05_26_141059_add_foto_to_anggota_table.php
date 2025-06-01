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
            Schema::table('anggota', function (Blueprint $table) {
                // Tambahkan kolom foto setelah kolom 'profil' (atau sesuaikan posisinya)
                // Pastikan kolom belum ada untuk menghindari error jika migrasi dijalankan ulang
                if (!Schema::hasColumn('anggota', 'foto')) {
                    $table->string('foto')->nullable()->after('profil');
                }
            });
        }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            //
        });
    }
};
