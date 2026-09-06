@php
    $heroPhoto = !empty($settings['hero_image']) 
        ? asset('storage/' . $settings['hero_image']) 
        : asset('images/hero-school.jpg');
@endphp

<section class="hero" style="position: relative; overflow: hidden; background: #DDD8C4;">
    {{-- Foto 2: Full dibelakang section hero, efek blur dan transparan opacity 40% (range 30%~50%) --}}
    <img src="{{ $heroPhoto }}" 
         alt="" 
         style="position: absolute; top: -20px; left: -20px; width: calc(100% + 40px); height: calc(100% + 40px); object-fit: cover; object-position: center; filter: blur(6px); opacity: 0.40; z-index: 0; pointer-events: none; transform: scale(1.04);"
         onerror="this.style.display='none';">

    <div class="container hero-grid" style="position: relative; z-index: 1;">
        <div style="background: rgba(237, 234, 217, 0.88); backdrop-filter: blur(8px); padding: 32px; border-radius: 4px; border: 1px solid var(--color-line); box-shadow: 0 8px 24px rgba(31, 42, 68, 0.10);">
            <h1 style="margin-top: 0; font-size: 38px; line-height: 1.2;">Membentuk siswa Surabaya yang berpikir jernih dan bertindak jujur sejak bangku SMP.</h1>
            <p class="lead" style="margin-bottom: 24px; font-size: 17px;">
                SMP Negeri 14 Surabaya membuka ruang belajar akademik dan pembentukan karakter Profil Pelajar Pancasila yang seimbang bagi peserta didik kelas VII hingga IX, dengan rekam jejak lulusan melanjutkan ke SMA/SMK negeri unggulan di Surabaya.
            </p>
            <div class="hero-cta" style="margin-bottom: 0;">
                <a href="{{ url('/ppdb') }}" class="btn-primary">Informasi SPMB Surabaya</a>
                <a href="{{ url('/profil') }}" class="btn-outline">Profil Sekolah</a>
            </div>
        </div>

        {{-- Foto 1: Foto utama tajam di sebelah kanan --}}
        <div class="hero-photo-wrap" style="position: relative; z-index: 2; box-shadow: 0 20px 40px rgba(31, 42, 68, 0.28); border: 2px solid var(--color-paper-alt); background: var(--color-paper-alt);">
            <img src="{{ $heroPhoto }}" alt="Gedung dan Kegiatan Siswa SMP Negeri 14 Surabaya" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'600\' height=\'450\' viewBox=\'0 0 600 450\'><rect width=\'600\' height=\'450\' fill=\'%23D8D3BF\'/><text x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'monospace\' font-size=\'14\' fill=\'%235A6478\'>Gedung &amp; Kegiatan SMPN 14 Surabaya</text></svg>';">
        </div>
    </div>
</section>
