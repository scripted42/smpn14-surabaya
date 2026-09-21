@php
    $heroImagePath = !empty($settings['hero_image']) ? $settings['hero_image'] : null;
    $hasHeroPhoto = false;
    $heroPhoto = null;

    if ($heroImagePath) {
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($heroImagePath)) {
            $hasHeroPhoto = true;
            $heroPhoto = asset('storage/' . $heroImagePath);
        } elseif (file_exists(public_path('storage/' . $heroImagePath))) {
            $hasHeroPhoto = true;
            $heroPhoto = asset('storage/' . $heroImagePath);
        } elseif (file_exists(public_path($heroImagePath))) {
            $hasHeroPhoto = true;
            $heroPhoto = asset($heroImagePath);
        }
    }
@endphp

<section class="hero" style="position: relative; overflow: hidden; background: linear-gradient(135deg, #0A182E 0%, #132B4F 100%);">
    @if ($hasHeroPhoto)
        {{-- Foto Full di belakang section hero, efek blur dan transparan --}}
        <img src="{{ $heroPhoto }}" 
             alt="" 
             style="position: absolute; top: -20px; left: -20px; width: calc(100% + 40px); height: calc(100% + 40px); object-fit: cover; object-position: center; filter: blur(8px); opacity: 0.42; z-index: 0; pointer-events: none; transform: scale(1.05);"
             onerror="this.style.display='none';">

        <div class="container hero-grid" style="position: relative; z-index: 1;">
            <div style="background: rgba(255, 255, 255, 0.94); backdrop-filter: blur(12px); padding: 28px 30px; border-radius: 4px; border: 1px solid rgba(255, 255, 255, 0.85); box-shadow: 0 16px 40px rgba(10, 24, 46, 0.16);">
                <h1 style="margin-top: 0; font-size: 34px; line-height: 1.22; color: var(--color-ink);">Membentuk siswa Surabaya yang berpikir jernih dan bertindak jujur sejak bangku SMP.</h1>
                <p class="lead" style="margin-bottom: 22px; font-size: 16px; line-height: 1.5; color: #445970;">
                    SMP Negeri 14 Surabaya membuka ruang belajar akademik dan pembentukan karakter Profil Pelajar Pancasila yang seimbang bagi peserta didik kelas VII hingga IX, dengan rekam jejak lulusan melanjutkan ke SMA/SMK negeri unggulan di Surabaya.
                </p>
                <div class="hero-cta" style="margin-bottom: 0;">
                    <a href="{{ url('/ppdb') }}" class="btn-primary" style="background: var(--color-teal); border-color: var(--color-teal); color: #FFF !important;">Informasi SPMB Surabaya</a>
                    <a href="{{ url('/profil') }}" class="btn-outline">Profil Sekolah</a>
                </div>
            </div>

            {{-- Foto utama tajam di sebelah kanan --}}
            <div class="hero-photo-wrap" style="position: relative; z-index: 2; box-shadow: 0 20px 40px rgba(10, 24, 46, 0.28); border: 2px solid #FFFFFF; background: #FFFFFF;">
                <img src="{{ $heroPhoto }}" alt="Gedung dan Kegiatan Siswa SMP Negeri 14 Surabaya" onerror="this.onerror=null; this.style.display='none';">
            </div>
        </div>
    @else
        {{-- Tampilan saat foto banner utama dihapus / kosong: Hanya menampilkan teks tanpa foto --}}
        <div class="container" style="position: relative; z-index: 1;">
            <div style="background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(12px); padding: 36px 40px; border-radius: 4px; border: 1px solid rgba(255, 255, 255, 0.85); box-shadow: 0 16px 40px rgba(10, 24, 46, 0.20); max-width: 820px;">
                <h1 style="margin-top: 0; font-size: 36px; line-height: 1.22; color: var(--color-ink);">Membentuk siswa Surabaya yang berpikir jernih dan bertindak jujur sejak bangku SMP.</h1>
                <p class="lead" style="margin-bottom: 24px; font-size: 16.5px; line-height: 1.6; color: #445970; max-width: 700px;">
                    SMP Negeri 14 Surabaya membuka ruang belajar akademik dan pembentukan karakter Profil Pelajar Pancasila yang seimbang bagi peserta didik kelas VII hingga IX, dengan rekam jejak lulusan melanjutkan ke SMA/SMK negeri unggulan di Surabaya.
                </p>
                <div class="hero-cta" style="margin-bottom: 0;">
                    <a href="{{ url('/ppdb') }}" class="btn-primary" style="background: var(--color-teal); border-color: var(--color-teal); color: #FFF !important;">Informasi SPMB Surabaya</a>
                    <a href="{{ url('/profil') }}" class="btn-outline">Profil Sekolah</a>
                </div>
            </div>
        </div>
    @endif
</section>
