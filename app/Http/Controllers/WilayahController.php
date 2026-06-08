<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Kembalikan semua provinsi — untuk inisialisasi dropdown pertama.
     */
    public function provinsi(): JsonResponse
    {
        $data = Provinsi::orderBy('nama')->get(['id', 'nama', 'kode_bps']);
        return response()->json($data);
    }

    /**
     * Kembalikan kabupaten/kota berdasarkan provinsi_id.
     */
    public function kabupaten(Request $request): JsonResponse
    {
        $provinsiId = $request->query('provinsi_id');

        if (!$provinsiId) {
            return response()->json([]);
        }

        $data = Kabupaten::where('provinsi_id', $provinsiId)
            ->orderBy('nama')
            ->get(['id', 'nama', 'kode_bps']);

        return response()->json($data);
    }

    /**
     * Kembalikan kecamatan berdasarkan kabupaten_id (kab_id).
     */
    public function kecamatan(Request $request): JsonResponse
    {
        $kabupatenId = $request->query('kabupaten_id');

        if (!$kabupatenId) {
            return response()->json([]);
        }

        $data = Kecamatan::where('kabupaten_id', $kabupatenId)
            ->orderBy('nama')
            ->get(['id', 'nama', 'kode_bps']);

        return response()->json($data);
    }
}
