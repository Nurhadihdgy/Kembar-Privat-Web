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
        Schema::table('artikels', function (Blueprint $table) {
            // Tambahkan kolom is_published setelah kolom tertentu, misalnya 'slug' atau 'isi'
            // Defaultnya true agar artikel yang sudah ada dianggap terbit
            // atau false jika Anda ingin meninjaunya satu per satu.
            if (!Schema::hasColumn('artikels', 'is_published')) {
                $table->boolean('is_published')->default(true)->after('isi'); // Sesuaikan 'after'
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            if (Schema::hasColumn('artikels', 'is_published')) {
                $table->dropColumn('is_published');
            }
        });
    }
};
