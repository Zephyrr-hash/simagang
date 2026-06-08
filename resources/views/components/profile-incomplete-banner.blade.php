{{--
    Komponen banner peringatan profil belum lengkap.
    Ditampilkan otomatis jika ada session 'profile_incomplete'.
    Sertakan di setiap halaman profile index: @include('components.profile-incomplete-banner')
--}}
@if(session('profile_incomplete'))
<div style="
    background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
    border: 1.5px solid #F59E0B;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
" role="alert">
    {{-- Icon --}}
    <div style="
        width:40px;height:40px;border-radius:10px;
        background:#F59E0B;display:flex;align-items:center;
        justify-content:center;flex-shrink:0;margin-top:1px;
    ">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </svg>
    </div>
    {{-- Teks --}}
    <div style="flex:1;">
        <p style="font-size:0.9rem;font-weight:700;color:#92400E;margin:0 0 0.3rem;">Profil Belum Lengkap</p>
        <p style="font-size:0.82rem;color:#78350F;margin:0;line-height:1.5;">
            {{ session('profile_incomplete') }}
        </p>
        <a href="{{ $editUrl ?? '#' }}"
           style="
               display:inline-flex;align-items:center;gap:0.4rem;
               margin-top:0.75rem;background:#F59E0B;color:#fff;
               border-radius:8px;padding:0.45rem 1.1rem;
               font-size:0.82rem;font-weight:600;text-decoration:none;
               transition:background 0.2s;
           "
           onmouseover="this.style.background='#D97706'"
           onmouseout="this.style.background='#F59E0B'">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16">
                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.146 4.207L9.793 1.146 4 6.94V7h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.06l5.793-5.793zM3.23 9.854l-.092.391A.5.5 0 0 0 3.5 11H4v-.5a.5.5 0 0 1 .5-.5H5v-.5a.5.5 0 0 1 .5-.5H6v-.5a.5.5 0 0 1 .146-.354l.734-.734-1.08-.27-2.57.963z"/>
            </svg>
            Lengkapi Sekarang
        </a>
    </div>
</div>
@endif
