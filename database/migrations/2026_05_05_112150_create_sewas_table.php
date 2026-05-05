<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->string('id_penyewaan', 20)->unique();
            $table->string('nama_penyewa', 100);
            $table->string('telepon', 15);
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('kamera_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah_unit');
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali');
            $table->string('metode_pembayaran');
            $table->text('catatan')->nullable();
            $table->bigInteger('total_harga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
