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
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengulas');
            $table->foreignId('layanan_id')->nullable()->constrained('layanans')->onDelete('set null'); // Relasi ke layanan yang diikuti
            $table->unsignedTinyInteger('rating')->default(5); // Rating bintang 1-5
            $table->text('ulasan');
            $table->boolean('is_tampil')->default(false); // Admin harus menyetujui untuk ditampilkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
