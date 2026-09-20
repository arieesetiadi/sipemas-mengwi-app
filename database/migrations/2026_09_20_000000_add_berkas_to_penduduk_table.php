<?php

use App\Enums\JenisLampiran;
use App\Enums\StatusPerkawinan;
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
        Schema::table('penduduk', function (Blueprint $table) {
            $table->enum('status_perkawinan', StatusPerkawinan::values())->nullable()->after('pekerjaan');
            $table->string('ktp_path')->nullable()->after('status_perkawinan');
            $table->string('kk_path')->nullable()->after('ktp_path');
        });

        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->dropColumn('status_perkawinan');
        });

        Schema::dropIfExists('lampiran');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropColumn(['status_perkawinan', 'ktp_path', 'kk_path']);
        });

        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->enum('status_perkawinan', StatusPerkawinan::values())->nullable();
        });

        Schema::create('lampiran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_surat_id')->nullable()->constrained('pengajuan_surat', 'id')->nullOnDelete();
            $table->enum('jenis_lampiran', JenisLampiran::values());
            $table->string('file_path');
            $table->timestamps();
        });
    }
};
