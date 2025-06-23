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
        Schema::create('antrians', function (Blueprint $table) {
            $table->id();            
            $table->string('nik_pasien', 16);
            $table->date('tanggal_kunjungan');
            $table->string('nomor_antrian');
            $table->string('nama_pasien');            
            $table->text('alamat_pasien');
            $table->char('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('nomor_whatsapp');
            $table->string('status')->default('antri');
            $table->string('pembayaran')->default('umum');
            $table->string('keluhan');
            $table->foreignId('poli_id')->constrained('polis')->onDelete('cascade');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};
