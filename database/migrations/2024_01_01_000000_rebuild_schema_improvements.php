<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RebuildSchemaImprovements extends Migration
{
    /**
     * Jalankan migration.
     * Berisi semua perbaikan schema untuk project SIMAGANG rebuild.
     *
     * @return void
     */
    public function up(): void
    {
        // =====================================================================
        // 1. Tabel `dosen` — ubah NIP dari integer ke string(20)
        // =====================================================================
        Schema::table('dosen', function (Blueprint $table) {
            // Hapus kolom integer lama, buat ulang sebagai string
            $table->string('NIP', 20)->nullable()->change();
        });

        // =====================================================================
        // 2. Tabel `supervisor` — ubah no_pegawai dari integer ke string(20)
        // =====================================================================
        Schema::table('supervisor', function (Blueprint $table) {
            $table->string('no_pegawai', 20)->nullable()->change();
        });

        // =====================================================================
        // 3. Tabel `lowongan` — ubah deskripsi_low dari string(255) ke text
        // =====================================================================
        Schema::table('lowongan', function (Blueprint $table) {
            $table->text('deskripsi_low')->change();
        });

        // =====================================================================
        // 4. Tabel `bimbingan` — ubah feedback dari string(255) ke text nullable
        // =====================================================================
        Schema::table('bimbingan', function (Blueprint $table) {
            $table->text('feedback')->nullable()->change();
        });

        // =====================================================================
        // 5. Tabel `logbook` — ubah deskripsi_log & saran ke text,
        //    tambah kolom catatan_spv (text nullable) setelah saran
        // =====================================================================
        Schema::table('logbook', function (Blueprint $table) {
            $table->text('deskripsi_log')->change();
            $table->text('saran')->nullable()->change();

            // Tambah kolom baru catatan_spv jika belum ada
            if (!Schema::hasColumn('logbook', 'catatan_spv')) {
                $table->text('catatan_spv')->nullable()->after('saran');
            }
        });

        // =====================================================================
        // 6. Tabel `mitra` — hapus UNIQUE constraint dari alamat_mitra,
        //    telepon_mitra, fax_mitra (jika ada)
        // =====================================================================
        $this->dropUniqueIfExists('mitra', 'mitra_alamat_mitra_unique', 'alamat_mitra');
        $this->dropUniqueIfExists('mitra', 'mitra_telepon_mitra_unique', 'telepon_mitra');
        $this->dropUniqueIfExists('mitra', 'mitra_fax_mitra_unique', 'fax_mitra');

        // =====================================================================
        // 7. Tambah index pada tabel-tabel yang sering di-query
        // =====================================================================

        // Index pada tabel `magang`
        Schema::table('magang', function (Blueprint $table) {
            $this->addIndexIfNotExists($table, 'magang', 'mhs_id', 'magang_mhs_id_index');
            $this->addIndexIfNotExists($table, 'magang', 'approval', 'magang_approval_index');
            $this->addIndexIfNotExists($table, 'magang', 'dosen_id', 'magang_dosen_id_index');
            $this->addIndexIfNotExists($table, 'magang', 'spv_id', 'magang_spv_id_index');
        });

        // Index pada tabel `logbook`
        Schema::table('logbook', function (Blueprint $table) {
            $this->addIndexIfNotExists($table, 'logbook', 'magang_id', 'logbook_magang_id_index');
        });

        // Index pada tabel `bimbingan`
        Schema::table('bimbingan', function (Blueprint $table) {
            $this->addIndexIfNotExists($table, 'bimbingan', 'magang_id', 'bimbingan_magang_id_index');
        });

        // Index pada tabel `mahasiswa`
        Schema::table('mahasiswa', function (Blueprint $table) {
            $this->addIndexIfNotExists($table, 'mahasiswa', 'user_id', 'mahasiswa_user_id_index');
            $this->addIndexIfNotExists($table, 'mahasiswa', 'status_id', 'mahasiswa_status_id_index');
            $this->addIndexIfNotExists($table, 'mahasiswa', 'depart_id', 'mahasiswa_depart_id_index');
        });

        // Index pada tabel `dosen`
        Schema::table('dosen', function (Blueprint $table) {
            $this->addIndexIfNotExists($table, 'dosen', 'user_id', 'dosen_user_id_index');
        });

        // Index pada tabel `supervisor`
        Schema::table('supervisor', function (Blueprint $table) {
            $this->addIndexIfNotExists($table, 'supervisor', 'user_id', 'supervisor_user_id_index');
            $this->addIndexIfNotExists($table, 'supervisor', 'mitra_id', 'supervisor_mitra_id_index');
        });

        // Index pada tabel `mitra`
        Schema::table('mitra', function (Blueprint $table) {
            $this->addIndexIfNotExists($table, 'mitra', 'user_id', 'mitra_user_id_index');
        });
    }

    /**
     * Balik semua perubahan migration.
     *
     * @return void
     */
    public function down(): void
    {
        // =====================================================================
        // Hapus index yang ditambahkan
        // =====================================================================
        Schema::table('magang', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'magang_mhs_id_index');
            $this->dropIndexIfExists($table, 'magang_approval_index');
            $this->dropIndexIfExists($table, 'magang_dosen_id_index');
            $this->dropIndexIfExists($table, 'magang_spv_id_index');
        });

        Schema::table('logbook', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'logbook_magang_id_index');
        });

        Schema::table('bimbingan', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'bimbingan_magang_id_index');
        });

        Schema::table('mahasiswa', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'mahasiswa_user_id_index');
            $this->dropIndexIfExists($table, 'mahasiswa_status_id_index');
            $this->dropIndexIfExists($table, 'mahasiswa_depart_id_index');
        });

        Schema::table('dosen', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'dosen_user_id_index');
        });

        Schema::table('supervisor', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'supervisor_user_id_index');
            $this->dropIndexIfExists($table, 'supervisor_mitra_id_index');
        });

        Schema::table('mitra', function (Blueprint $table) {
            $this->dropIndexIfExists($table, 'mitra_user_id_index');
        });

        // =====================================================================
        // Kembalikan UNIQUE constraint pada tabel `mitra`
        // =====================================================================
        Schema::table('mitra', function (Blueprint $table) {
            $table->unique('alamat_mitra');
            $table->unique('telepon_mitra');
            $table->unique('fax_mitra');
        });

        // =====================================================================
        // Hapus kolom catatan_spv dari logbook
        // =====================================================================
        Schema::table('logbook', function (Blueprint $table) {
            if (Schema::hasColumn('logbook', 'catatan_spv')) {
                $table->dropColumn('catatan_spv');
            }
        });

        // =====================================================================
        // Kembalikan tipe kolom ke semula
        // =====================================================================
        Schema::table('logbook', function (Blueprint $table) {
            $table->string('deskripsi_log', 255)->change();
            $table->string('saran', 255)->nullable()->change();
        });

        Schema::table('bimbingan', function (Blueprint $table) {
            $table->string('feedback', 255)->nullable()->change();
        });

        Schema::table('lowongan', function (Blueprint $table) {
            $table->string('deskripsi_low', 255)->change();
        });

        Schema::table('supervisor', function (Blueprint $table) {
            $table->integer('no_pegawai')->nullable()->change();
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->integer('NIP')->nullable()->change();
        });
    }

    /**
     * Tambah index pada kolom jika belum ada.
     * Menggunakan try-catch agar idempotent.
     */
    private function addIndexIfNotExists(Blueprint $table, string $tableName, string $column, string $indexName): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = ?", [$indexName]);
            if (empty($indexes)) {
                $table->index($column, $indexName);
            }
        } catch (\Exception $e) {
            // Index mungkin sudah ada atau terjadi error lain — lewati
        }
    }

    /**
     * Hapus index jika ada.
     * Menggunakan try-catch agar idempotent.
     */
    private function dropIndexIfExists(Blueprint $table, string $indexName): void
    {
        try {
            $table->dropIndex($indexName);
        } catch (\Exception $e) {
            // Index tidak ada — lewati
        }
    }

    /**
     * Hapus UNIQUE constraint dari kolom jika ada.
     * Menggunakan raw SQL agar lebih reliable di MySQL.
     */
    private function dropUniqueIfExists(string $tableName, string $indexName, string $column): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = ?", [$indexName]);
            if (!empty($indexes)) {
                DB::statement("ALTER TABLE `{$tableName}` DROP INDEX `{$indexName}`");
            }
        } catch (\Exception $e) {
            // Index tidak ada atau sudah dihapus — lewati
        }
    }
}
