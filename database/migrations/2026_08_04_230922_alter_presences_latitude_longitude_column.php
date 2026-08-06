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
        Schema::table('presences', function (Blueprint $table) {
            // Ubah menjadi string tanpa batasan ketat agar muat menampung koordinat GPS
            $table->string('latitude')->nullable()->change();
            $table->string('longitude')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan kolom latitude dan longitude ke tipe data sebelumnya jika terjadi rollback
        Schema::table('presences', function (Blueprint $table) {
            $table->string('latitude', 10, 7)->nullable()->change();
            $table->string('longitude', 10, 7)->nullable()->change();
        });
    }
};
