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
        Schema::create('like_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foto_id');
            $table->foreignId('user_id');
            $table->timestamp('tanggal_like')->default(now())->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like_fotos');
        Schema::table('like_fotos', function (Blueprint $table) {
            $table->timestamp('tanggal_like')->nullable()->change();
        });
    }
};
