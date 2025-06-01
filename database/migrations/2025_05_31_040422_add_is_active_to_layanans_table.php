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
            // Tambahkan kolom is_active setelah kolom tertentu, misalnya 'harga' atau 'slug'
            // Defaultnya true agar layanan yang sudah ada dianggap aktif
            if (!Schema::hasColumn('layanans', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('slug'); // Sesuaikan 'after()' dengan nama kolom yang ada
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            if (Schema::hasColumn('layanans', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
