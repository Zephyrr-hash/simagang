@extends('layouts.app')
@section('title', 'Edit Profil')
@section('breadcrumb')
<nav aria-label="breadcrumb"><ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('mitra.home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profil</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ol></nav>
@endsection
@push('styles')
<style>
.form-card{background:#fff;border:1px solid #E0E7FF;border-radius:14px;overflow:hidden;width:100%;max-width:none;}
.form-card-header{background:linear-gradient(135deg,#4F46E5,#7C3AED);padding:1.25rem 1.75rem;color:#fff;}
.form-card-header h1{font-size:1.1rem;font-weight:700;margin:0 0 0.2rem;}
.form-card-header p{font-size:0.82rem;opacity:0.85;margin:0;}
.form-card-body{padding:1.75rem;}
.form-group{margin-bottom:1.25rem;}
.form-label{display:block;font-size:0.8rem;font-weight:600;color:#374151;margin-bottom:0.4rem;}
.form-label .req{color:#EF4444;margin-left:2px;}
.form-control-c{width:100%;padding:0.65rem 1rem;border:1.5px solid #E5E7EB;border-radius:9px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#1E1B4B;background:#FAFAFA;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.form-control-c:focus{border-color:#4F46E5;background:#fff;box-shadow:0 0 0 3px rgba(79,70,229,0.1);}
.form-control-c:disabled{background:#F3F4F6;color:#9CA3AF;cursor:not-allowed;}
.form-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:575px){.form-row-2{grid-template-columns:1fr;}}
.form-actions{display:flex;gap:0.75rem;padding-top:1.25rem;border-top:1px solid #F3F4F6;margin-top:0.5rem;}
.btn-save{background:linear-gradient(135deg,#4F46E5,#7C3AED);color:#fff;border:none;border-radius:9px;padding:0.65rem 1.75rem;font-weight:600;font-size:0.9rem;cursor:pointer;transition:opacity 0.2s;font-family:'Inter',sans-serif;}
.btn-save:hover{opacity:0.88;}
.btn-cancel{background:#fff;color:#6B7280;border:1.5px solid #D1D5DB;border-radius:9px;padding:0.65rem 1.25rem;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;}
.btn-cancel:hover{background:#F9FAFB;color:#374151;}
.error-alert{background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:0.875rem 1rem;margin-bottom:1.25rem;font-size:0.85rem;color:#DC2626;}
.error-alert ul{margin:0.4rem 0 0;padding-left:1.25rem;}
.section-divider{font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#6B7280;margin:1.5rem 0 1rem;display:flex;align-items:center;gap:0.5rem;}
.section-divider::after{content:'';flex:1;height:1px;background:#E0E7FF;}
.loading-spinner{display:inline-block;width:14px;height:14px;border:2px solid #C7D2FE;border-top-color:#4F46E5;border-radius:50%;animation:spin 0.6s linear infinite;margin-left:0.5rem;vertical-align:middle;}
@keyframes spin{to{transform:rotate(360deg);}}
</style>
@endpush

@section('content')
<div class="form-card">
    <div class="form-card-header">
        <h1>Edit Profil Mitra</h1>
        <p>Perbarui informasi perusahaan Anda.</p>
    </div>
    <div class="form-card-body">
        @if(session('errorForm'))
        <div class="error-alert"><strong>Terdapat kesalahan:</strong><ul>@foreach(session('errorForm') as $msgs)@foreach($msgs as $m)<li>{{ $m }}</li>@endforeach @endforeach</ul></div>
        @endif

        <form action="{{ route('profile.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- ===== INFORMASI PERUSAHAAN ===== --}}
            <div class="section-divider">Informasi Perusahaan</div>

            <div class="form-group">
                <label class="form-label">Nama Perusahaan <span class="req">*</span></label>
                <input type="text" name="nama_mitra" class="form-control-c"
                       value="{{ old('nama_mitra', $profile?->nama_mitra) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Alamat Lengkap <span class="req">*</span></label>
                <textarea name="alamat_mitra" class="form-control-c" rows="3" required>{{ old('alamat_mitra', $profile?->alamat_mitra) }}</textarea>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label">Telepon <span class="req">*</span></label>
                    <input type="text" name="telepon_mitra" class="form-control-c"
                           value="{{ old('telepon_mitra', $profile?->telepon_mitra) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Fax</label>
                    <input type="text" name="fax_mitra" class="form-control-c"
                           value="{{ old('fax_mitra', $profile?->fax_mitra) }}">
                </div>
            </div>

            {{-- ===== WILAYAH ===== --}}
            <div class="section-divider">Wilayah</div>

            {{-- Provinsi --}}
            <div class="form-group">
                <label class="form-label" for="provinsi_id">Provinsi <span class="req">*</span></label>
                <select name="provinsi_id" id="provinsi_id" class="form-control-c" required>
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach($provinsis as $prov)
                        <option value="{{ $prov->id }}"
                            {{ old('provinsi_id', $profile?->provinsi_id) == $prov->id ? 'selected' : '' }}>
                            {{ $prov->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kabupaten/Kota --}}
            <div class="form-group">
                <label class="form-label" for="kab_id">
                    Kabupaten/Kota <span class="req">*</span>
                    <span id="kab-spinner" class="loading-spinner" style="display:none;"></span>
                </label>
                <select name="kab_id" id="kab_id" class="form-control-c" required
                        {{ $provinsis->isEmpty() ? 'disabled' : '' }}>
                    <option value="">-- Pilih Kabupaten/Kota --</option>
                    @foreach($kabupatens as $kab)
                        <option value="{{ $kab->id }}"
                            {{ old('kab_id', $profile?->kab_id) == $kab->id ? 'selected' : '' }}>
                            {{ $kab->nama }}
                        </option>
                    @endforeach
                </select>
                @if($provinsis->isEmpty())
                <p style="font-size:0.75rem;color:#F59E0B;margin-top:0.35rem;">
                    ⚠ Data wilayah belum tersedia. Jalankan: <code>php artisan wilayah:sync --provinsi --kabupaten</code>
                </p>
                @endif
            </div>

            {{-- Kecamatan --}}
            <div class="form-group">
                <label class="form-label" for="kecamatan_id">
                    Kecamatan
                    <span id="kec-spinner" class="loading-spinner" style="display:none;"></span>
                </label>
                <select name="kecamatan_id" id="kecamatan_id" class="form-control-c"
                        {{ $profile?->kab_id ? '' : 'disabled' }}>
                    <option value="">-- Pilih Kecamatan (opsional) --</option>
                    @foreach($kecamatans as $kec)
                        <option value="{{ $kec->id }}"
                            {{ old('kecamatan_id', $profile?->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                            {{ $kec->nama }}
                        </option>
                    @endforeach
                </select>
                @if($profile?->kab_id && $kecamatans->isEmpty())
                <p style="font-size:0.75rem;color:#F59E0B;margin-top:0.35rem;">
                    ⚠ Data kecamatan belum tersedia. Jalankan: <code>php artisan wilayah:sync --kecamatan</code>
                </p>
                @endif
            </div>

            {{-- Kode Pos --}}
            <div class="form-group" style="max-width:180px;">
                <label class="form-label" for="kode_pos">Kode Pos</label>
                <input type="text" name="kode_pos" id="kode_pos" class="form-control-c"
                       value="{{ old('kode_pos', $profile?->kode_pos) }}"
                       placeholder="5 digit, contoh: 12345"
                       maxlength="5" pattern="[0-9]{5}"
                       inputmode="numeric">
            </div>

            {{-- ===== FOTO ===== --}}
            <div class="section-divider">Foto</div>

            <div class="form-group">
                <label class="form-label">Foto Perusahaan</label>
                @if($profile?->foto_mitra && $profile->foto_mitra !== 'avatar.png')
                    <p style="font-size:0.8rem;color:#6B7280;margin-bottom:0.4rem;">
                        Foto saat ini: <strong>{{ $profile->foto_mitra }}</strong>
                    </p>
                @endif
                <input type="file" name="foto_mitra" class="form-control-c"
                       accept="image/jpeg,image/png,image/jpg">
                <p style="font-size:0.75rem;color:#9CA3AF;margin-top:0.3rem;">
                    Format: JPG, PNG. Maks 2MB.
                </p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Perubahan</button>
                <a href="{{ route('profile.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const provinsiSel   = document.getElementById('provinsi_id');
    const kabupatenSel  = document.getElementById('kab_id');
    const kecamatanSel  = document.getElementById('kecamatan_id');
    const kabSpinner    = document.getElementById('kab-spinner');
    const kecSpinner    = document.getElementById('kec-spinner');

    const savedKabId  = {{ old('kab_id', $profile?->kab_id ?? 'null') }};
    const savedKecId  = {{ old('kecamatan_id', $profile?->kecamatan_id ?? 'null') }};

    /**
     * Fetch JSON dari endpoint wilayah.
     */
    async function fetchWilayah(url) {
        const response = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!response.ok) throw new Error('Gagal memuat data wilayah.');
        return response.json();
    }

    /**
     * Isi dropdown dengan array [{id, nama}].
     */
    function fillSelect(selectEl, items, savedId, placeholder) {
        selectEl.innerHTML = `<option value="">${placeholder}</option>`;
        items.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.textContent = item.nama;
            if (savedId && parseInt(item.id) === parseInt(savedId)) {
                opt.selected = true;
            }
            selectEl.appendChild(opt);
        });
        selectEl.disabled = items.length === 0;
    }

    /**
     * Load kabupaten berdasarkan provinsi_id.
     */
    async function loadKabupaten(provinsiId, savedKab) {
        if (!provinsiId) {
            fillSelect(kabupatenSel, [], null, '-- Pilih Kabupaten/Kota --');
            fillSelect(kecamatanSel, [], null, '-- Pilih Kecamatan (opsional) --');
            kabupatenSel.disabled = true;
            kecamatanSel.disabled = true;
            return;
        }

        kabSpinner.style.display = 'inline-block';
        kabupatenSel.disabled = true;

        try {
            const data = await fetchWilayah(
                `{{ route('api.wilayah.kabupaten') }}?provinsi_id=${provinsiId}`
            );
            fillSelect(kabupatenSel, data, savedKab, '-- Pilih Kabupaten/Kota --');
            kabupatenSel.disabled = false;

            // Jika ada savedKab, load kecamatan-nya sekalian
            if (savedKab) {
                await loadKecamatan(savedKab, savedKecId);
            }
        } catch (e) {
            console.error(e);
            fillSelect(kabupatenSel, [], null, '-- Gagal memuat --');
        } finally {
            kabSpinner.style.display = 'none';
        }
    }

    /**
     * Load kecamatan berdasarkan kabupaten_id.
     */
    async function loadKecamatan(kabupatenId, savedKec) {
        if (!kabupatenId) {
            fillSelect(kecamatanSel, [], null, '-- Pilih Kecamatan (opsional) --');
            kecamatanSel.disabled = true;
            return;
        }

        kecSpinner.style.display = 'inline-block';
        kecamatanSel.disabled = true;

        try {
            const data = await fetchWilayah(
                `{{ route('api.wilayah.kecamatan') }}?kabupaten_id=${kabupatenId}`
            );
            fillSelect(kecamatanSel, data, savedKec, '-- Pilih Kecamatan (opsional) --');
            // Kecamatan opsional — enable meski kosong agar user tetap bisa simpan tanpa kecamatan
            kecamatanSel.disabled = false;
        } catch (e) {
            console.error(e);
            fillSelect(kecamatanSel, [], null, '-- Gagal memuat --');
            kecamatanSel.disabled = false;
        } finally {
            kecSpinner.style.display = 'none';
        }
    }

    // Event: provinsi berubah
    provinsiSel.addEventListener('change', function () {
        loadKabupaten(this.value, null);
    });

    // Event: kabupaten berubah
    kabupatenSel.addEventListener('change', function () {
        loadKecamatan(this.value, null);
    });

    // Inisialisasi: jika sudah ada nilai tersimpan, reload dropdown
    const savedProvinsiId = provinsiSel.value;
    if (savedProvinsiId && !savedKabId) {
        // Provinsi sudah dipilih tapi kabupaten belum (validasi gagal)
        loadKabupaten(savedProvinsiId, null);
    } else if (savedProvinsiId && savedKabId) {
        // Reload untuk pastikan kecamatan terisi
        loadKecamatan(savedKabId, savedKecId);
    }

    // Validasi kode pos — hanya angka
    const kodePosInput = document.getElementById('kode_pos');
    if (kodePosInput) {
        kodePosInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 5);
        });
    }
})();
</script>
@endpush
