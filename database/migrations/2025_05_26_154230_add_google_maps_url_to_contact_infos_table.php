<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('contact_infos', function (Blueprint $table) {
            $table->text('google_maps_url')->nullable()->after('whatsapp');
        });
    }

    public function down()
    {
        Schema::table('contact_infos', function (Blueprint $table) {
            $table->dropColumn('google_maps_url');
        });
    }
};
