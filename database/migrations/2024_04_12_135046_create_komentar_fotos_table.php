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
        Schema::create('komentar_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foto_id');
            $table->foreignId('user_id');
            $table->text('isi_komentar');
            $table->timestamp('tanggal_komentar')->default(now())->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_fotos');
        Schema::table('kometar_fotos', function (Blueprint $table) {
            $table->timestamp('tanggal_komentar')->nullable()->change();
        });
    }
};
