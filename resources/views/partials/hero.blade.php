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
            {{-- Kartu Teks Sambutan (Desktop: Kiri, Mobile: Bawah Foto) --}}
            <div class="hero-card">
                <h1 class="hero-title">Membentuk siswa Surabaya yang berpikir jernih dan bertindak jujur sejak bangku SMP.</h1>
                <p class="lead hero-lead">
                    SMP Negeri 14 Surabaya membuka ruang belajar akademik dan pembentukan karakter Profil Pelajar Pancasila yang seimbang bagi peserta didik kelas VII hingga IX, dengan rekam jejak lulusan melanjutkan ke SMA/SMK negeri unggulan di Surabaya.
                </p>
                <div class="hero-cta">
                    <a href="{{ url('/ppdb') }}" class="btn-primary" style="background: var(--color-teal); border-color: var(--color-teal); color: #FFF !important;">Informasi SPMB Surabaya</a>
                    <a href="{{ url('/profil') }}" class="btn-outline">Profil Sekolah</a>
                </div>
            </div>

            {{-- Foto Utama Tajam (Desktop: Kanan, Mobile: Tampil di Atas Teks secara Penuh & Proporsional) --}}
            <div class="hero-photo-wrap">
                <img src="{{ $heroPhoto }}" alt="Gedung dan Kegiatan Siswa SMP Negeri 14 Surabaya" onerror="this.onerror=null; this.style.display='none';">
            </div>
        </div>
    @else
        {{-- Tampilan saat foto banner utama dihapus / kosong: Hanya menampilkan teks tanpa foto --}}
        <div class="container" style="position: relative; z-index: 1;">
            <div class="hero-card hero-card--solo">
                <h1 class="hero-title hero-title--solo">Membentuk siswa Surabaya yang berpikir jernih dan bertindak jujur sejak bangku SMP.</h1>
                <p class="lead hero-lead">
                    SMP Negeri 14 Surabaya membuka ruang belajar akademik dan pembentukan karakter Profil Pelajar Pancasila yang seimbang bagi peserta didik kelas VII hingga IX, dengan rekam jejak lulusan melanjutkan ke SMA/SMK negeri unggulan di Surabaya.
                </p>
                <div class="hero-cta">
                    <a href="{{ url('/ppdb') }}" class="btn-primary" style="background: var(--color-teal); border-color: var(--color-teal); color: #FFF !important;">Informasi SPMB Surabaya</a>
                    <a href="{{ url('/profil') }}" class="btn-outline">Profil Sekolah</a>
                </div>
            </div>
        </div>
    @endif
</section>
