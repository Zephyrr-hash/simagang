<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnhanceWilayahTables extends Migration
{
    public function up(): void
    {
        // =====================================================================
        // 1. Tambah kolom pada tabel `kabupaten`
        //    - kode_bps : kode BPS dari API (misal "3171")
        //    - provinsi_id : referensi ke tabel provinsi baru
        // =====================================================================
        Schema::table('kabupaten', function (Blueprint $table) {
            if (!Schema::hasColumn('kabupaten', 'kode_bps')) {
                $table->string('kode_bps', 10)->nullable()->unique()->after('nama')
                      ->comment('Kode BPS kabupaten/kota dari API wilayah');
            }
            if (!Schema::hasColumn('kabupaten', 'provinsi_id')) {
                $table->unsignedBigInteger('provinsi_id')->nullable()->after('kode_bps')
                      ->comment('FK ke tabel provinsi');
            }
        });

        // =====================================================================
        // 2. Buat tabel `provinsi` jika belum ada
        // =====================================================================
        if (!Schema::hasTable('provinsi')) {
            Schema::create('provinsi', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 100);
                $table->string('kode_bps', 10)->nullable()->unique()
                      ->comment('Kode BPS provinsi dari API wilayah');
                $table->timestamps();
            });
        }

        // =====================================================================
        // 3. Buat tabel `kecamatan` jika belum ada
        // =====================================================================
        if (!Schema::hasTable('kecamatan')) {
            Schema::create('kecamatan', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 150);
                $table->string('kode_bps', 10)->nullable()->unique()
                      ->comment('Kode BPS kecamatan dari API wilayah');
                $table->unsignedBigInteger('kabupaten_id')->nullable();
                $table->foreign('kabupaten_id')->references('id')->on('kabupaten')
                      ->onDelete('cascade');
                $table->index('kabupaten_id');
                $table->timestamps();
            });
        }

        // =====================================================================
        // 4. Tambah kolom pada tabel `mitra`
        //    - provinsi_id : provinsi perusahaan
        //    - kecamatan_id : kecamatan perusahaan
        //    - kode_pos : kode pos (string, opsional)
        // =====================================================================
        Schema::table('mitra', function (Blueprint $table) {
            if (!Schema::hasColumn('mitra', 'provinsi_id')) {
                $table->unsignedBigInteger('provinsi_id')->nullable()->after('kab_id')
                      ->comment('FK ke tabel provinsi');
            }
            if (!Schema::hasColumn('mitra', 'kecamatan_id')) {
                $table->unsignedBigInteger('kecamatan_id')->nullable()->after('provinsi_id')
                      ->comment('FK ke tabel kecamatan');
            }
            if (!Schema::hasColumn('mitra', 'kode_pos')) {
                $table->string('kode_pos', 10)->nullable()->after('kecamatan_id')
                      ->comment('Kode pos alamat mitra');
            }
        });

        // Foreign key untuk provinsi_id di kabupaten
        try {
            Schema::table('kabupaten', function (Blueprint $table) {
                $table->foreign('provinsi_id')->references('id')->on('provinsi')
                      ->onDelete('set null');
                $table->index('provinsi_id');
            });
        } catch (\Exception $e) {
            // FK mungkin sudah ada
        }

        // Foreign key untuk mitra
        try {
            Schema::table('mitra', function (Blueprint $table) {
                $table->foreign('provinsi_id')->references('id')->on('provinsi')
                      ->onDelete('set null');
                $table->foreign('kecamatan_id')->references('id')->on('kecamatan')
                      ->onDelete('set null');
                $table->index('kecamatan_id');
            });
        } catch (\Exception $e) {
            // FK mungkin sudah ada
        }
    }

    public function down(): void
    {
        // Hapus FK dan kolom dari mitra
        Schema::table('mitra', function (Blueprint $table) {
            try { $table->dropForeign(['kecamatan_id']); } catch (\Exception $e) {}
            try { $table->dropForeign(['provinsi_id']); } catch (\Exception $e) {}
            try { $table->dropIndex('mitra_kecamatan_id_index'); } catch (\Exception $e) {}
            if (Schema::hasColumn('mitra', 'kode_pos')) $table->dropColumn('kode_pos');
            if (Schema::hasColumn('mitra', 'kecamatan_id')) $table->dropColumn('kecamatan_id');
            if (Schema::hasColumn('mitra', 'provinsi_id')) $table->dropColumn('provinsi_id');
        });

        // Hapus tabel kecamatan
        Schema::dropIfExists('kecamatan');

        // Hapus kolom dari kabupaten
        Schema::table('kabupaten', function (Blueprint $table) {
            try { $table->dropForeign(['provinsi_id']); } catch (\Exception $e) {}
            try { $table->dropIndex('kabupaten_provinsi_id_index'); } catch (\Exception $e) {}
            if (Schema::hasColumn('kabupaten', 'provinsi_id')) $table->dropColumn('provinsi_id');
            if (Schema::hasColumn('kabupaten', 'kode_bps')) $table->dropColumn('kode_bps');
        });

        // Hapus tabel provinsi
        Schema::dropIfExists('provinsi');
    }
}
