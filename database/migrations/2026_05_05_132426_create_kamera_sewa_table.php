<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamera_sewa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kamera_id')->constrained()->onDelete('cascade');
            $table->foreignId('sewa_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_unit')->default(1);
            $table->bigInteger('harga_satuan'); 
            $table->timestamps();

            $table->unique(['kamera_id', 'sewa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamera_sewa');
    }
};
