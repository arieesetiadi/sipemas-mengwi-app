<?php

use App\Enums\JenisLampiran;
use App\Enums\StatusPerkawinan;
use App\Enums\StatusSurat;
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
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk', 'id')->nullOnDelete();
            $table->foreignId('jenis_surat_id')->nullable()->constrained('jenis_surat', 'id')->nullOnDelete();
            $table->enum('status', StatusSurat::values())->default(StatusSurat::Diajukan);
            $table->string('nomor_surat')->nullable()->unique();
            $table->tinyText('catatan')->nullable();
            $table->text('catatan_penolakan')->nullable();

            $table->enum('status_perkawinan', StatusPerkawinan::values())->nullable();

            $table->string('tujuan_instansi')->nullable();
            $table->string('keperluan')->nullable();

            $table->string('nama_usaha')->nullable();
            $table->string('lokasi_usaha')->nullable();

            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('admins', 'id')->nullOnDelete();
            $table->timestamp('diverifikasi_pada')->nullable();

            $table->foreignId('ditolak_oleh')->nullable()->constrained('admins', 'id')->nullOnDelete();
            $table->timestamp('ditolak_pada')->nullable();

            $table->foreignId('disetujui_oleh')->nullable()->constrained('admins', 'id')->nullOnDelete();
            $table->timestamp('disetujui_pada')->nullable();

            $table->timestamps();
        });

        Schema::create('lampiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_surat_id')->nullable()->constrained('pengajuan_surat', 'id')->nullOnDelete();
            $table->enum('jenis_lampiran', JenisLampiran::values());
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat');
    }
};
