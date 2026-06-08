<?php

namespace App\Console\Commands;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncWilayah extends Command
{
    /**
     * Sumber API: https://ibnux.github.io/data-indonesia/
     * Struktur:
     *   Provinsi  : GET /provinsi.json
     *   Kabupaten : GET /kabupaten/{kode_provinsi}.json
     *   Kecamatan : GET /kecamatan/{kode_kabupaten}.json
     */
    protected const BASE_URL = 'https://ibnux.github.io/data-indonesia';

    protected $signature = 'wilayah:sync
                            {--provinsi : Hanya sync data provinsi}
                            {--kabupaten : Hanya sync data kabupaten}
                            {--kecamatan : Hanya sync data kecamatan}
                            {--prov-id= : Sync kecamatan untuk kode provinsi tertentu saja}
                            {--force : Paksa update meski data sudah ada}';

    protected $description = 'Sinkronisasi data wilayah Indonesia (provinsi, kabupaten, kecamatan) dari API eksternal';

    public function handle(): int
    {
        $syncProvinsi  = $this->option('provinsi');
        $syncKabupaten = $this->option('kabupaten');
        $syncKecamatan = $this->option('kecamatan');
        $force         = $this->option('force');

        // Jika tidak ada flag spesifik, sync semua
        $syncAll = !$syncProvinsi && !$syncKabupaten && !$syncKecamatan;

        $this->info('=== SYNC WILAYAH INDONESIA ===');
        $this->info('Sumber: ' . self::BASE_URL);
        $this->newLine();

        try {
            DB::beginTransaction();

            if ($syncAll || $syncProvinsi) {
                $this->syncProvinsi($force);
            }

            if ($syncAll || $syncKabupaten) {
                $this->syncKabupaten($force);
            }

            if ($syncAll || $syncKecamatan) {
                $provId = $this->option('prov-id');
                $this->syncKecamatan($force, $provId);
            }

            DB::commit();
            $this->newLine();
            $this->info('✅ Sinkronisasi selesai!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ Terjadi kesalahan: ' . $e->getMessage());
            Log::error('SyncWilayah failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    private function syncProvinsi(bool $force): void
    {
        $this->info('📍 Sinkronisasi Provinsi...');

        $data = $this->fetchJson('/provinsi.json');
        if (empty($data)) {
            $this->warn('  Tidak ada data provinsi dari API.');
            return;
        }

        $bar = $this->output->createProgressBar(count($data));
        $bar->start();

        $inserted = 0;
        $updated  = 0;

        foreach ($data as $item) {
            $existing = Provinsi::where('kode_bps', $item['id'])->first();

            if ($existing) {
                if ($force) {
                    $existing->update(['nama' => $item['nama']]);
                    $updated++;
                }
            } else {
                Provinsi::create([
                    'nama'     => $item['nama'],
                    'kode_bps' => $item['id'],
                ]);
                $inserted++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line("  → Ditambahkan: {$inserted}, Diperbarui: {$updated}");
    }

    private function syncKabupaten(bool $force): void
    {
        $this->info('🏙️  Sinkronisasi Kabupaten/Kota...');

        $provinsis = Provinsi::all();
        if ($provinsis->isEmpty()) {
            $this->warn('  Belum ada data provinsi. Jalankan --provinsi terlebih dahulu.');
            return;
        }

        $totalInserted = 0;
        $totalUpdated  = 0;

        $bar = $this->output->createProgressBar($provinsis->count());
        $bar->start();

        foreach ($provinsis as $prov) {
            $data = $this->fetchJson("/kabupaten/{$prov->kode_bps}.json");

            foreach ($data as $item) {
                $existing = Kabupaten::where('kode_bps', $item['id'])->first();

                if ($existing) {
                    if ($force) {
                        $existing->update([
                            'nama'        => $item['nama'],
                            'provinsi_id' => $prov->id,
                        ]);
                        $totalUpdated++;
                    }
                } else {
                    Kabupaten::create([
                        'nama'        => $item['nama'],
                        'kode_bps'    => $item['id'],
                        'provinsi_id' => $prov->id,
                    ]);
                    $totalInserted++;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line("  → Ditambahkan: {$totalInserted}, Diperbarui: {$totalUpdated}");
    }

    private function syncKecamatan(bool $force, ?string $filterProvKode = null): void
    {
        $this->info('📌 Sinkronisasi Kecamatan...');
        $this->warn('  (Proses ini memakan waktu beberapa menit)');

        $query = Kabupaten::whereNotNull('kode_bps');
        if ($filterProvKode) {
            $prov  = Provinsi::where('kode_bps', $filterProvKode)->first();
            if (!$prov) {
                $this->warn("  Provinsi dengan kode '{$filterProvKode}' tidak ditemukan.");
                return;
            }
            $query->where('provinsi_id', $prov->id);
            $this->info("  Filter: Provinsi {$prov->nama}");
        }

        $kabupatens    = $query->get();
        $totalInserted = 0;
        $totalUpdated  = 0;

        $bar = $this->output->createProgressBar($kabupatens->count());
        $bar->start();

        foreach ($kabupatens as $kab) {
            $data = $this->fetchJson("/kecamatan/{$kab->kode_bps}.json");

            foreach ($data as $item) {
                $existing = Kecamatan::where('kode_bps', $item['id'])->first();

                if ($existing) {
                    if ($force) {
                        $existing->update([
                            'nama'         => $item['nama'],
                            'kabupaten_id' => $kab->id,
                        ]);
                        $totalUpdated++;
                    }
                } else {
                    Kecamatan::create([
                        'nama'         => $item['nama'],
                        'kode_bps'     => $item['id'],
                        'kabupaten_id' => $kab->id,
                    ]);
                    $totalInserted++;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->line("  → Ditambahkan: {$totalInserted}, Diperbarui: {$totalUpdated}");
    }

    /**
     * Fetch JSON dari API dengan retry sederhana.
     */
    private function fetchJson(string $path): array
    {
        $url = self::BASE_URL . $path;

        try {
            $response = Http::timeout(15)
                ->retry(3, 1000)
                ->get($url);

            if ($response->successful()) {
                return $response->json() ?? [];
            }

            $this->warn("  HTTP {$response->status()} saat fetch: {$url}");
            return [];
        } catch (\Exception $e) {
            Log::warning("SyncWilayah: Gagal fetch {$url}", ['error' => $e->getMessage()]);
            return [];
        }
    }
}
