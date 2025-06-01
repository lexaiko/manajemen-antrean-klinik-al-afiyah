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
            $table->foreignId('registered_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->string('nomor_antrian');
            $table->string('nama_pasien');
            $table->string('nik_pasien', 16);
            $table->text('alamat_pasien');
            $table->char('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('status')->default('menunggu');
            $table->string('pembayaran')->default('reguler');
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
