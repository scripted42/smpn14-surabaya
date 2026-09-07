@php
    $headerSettings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
    $schoolLogo = !empty($headerSettings['school_logo']) 
        ? (str_starts_with($headerSettings['school_logo'], 'images/') ? asset($headerSettings['school_logo']) : asset('storage/' . $headerSettings['school_logo']))
        : asset('images/logo-smpn14.png');
    $runningText = $headerSettings['running_announcement'] 
        ?? 'Selamat Datang di Website Resmi SMP Negeri 14 Surabaya · Informasi Resmi SPMB Tahun Pelajaran 2026/2027 Telah Dibuka! · Posko Meja Bantuan Buka di Ruang Tata Usaha';
@endphp

<header class="site-header">
    <div class="header-inner">
        <a href="{{ route('home') }}" class="brand">
            <img src="{{ $schoolLogo }}" alt="Logo SMP Negeri 14 Surabaya" style="width: 44px; height: 44px; object-fit: contain; flex-shrink: 0;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="brand-mark" style="display:none; width:44px; height:44px; background:var(--color-ink); color:#fff; align-items:center; justify-content:center; font-weight:bold; border-radius:2px;">14</div>
            <div>
                <div class="brand-name">SMP Negeri 14 Surabaya</div>
                <div class="brand-sub">Sekolah Menengah Pertama Negeri · Kota Surabaya</div>
            </div>
        </a>

        <nav class="main-nav">
            <ul>
                <li><a href="{{ url('/profil') }}" class="{{ request()->is('profil*') ? 'active' : '' }}">Profil</a></li>
                <li><a href="{{ url('/guru-staff') }}" class="{{ request()->is('guru-staff*') ? 'active' : '' }}">Guru & Staf</a></li>
                <li><a href="{{ url('/akademik') }}" class="{{ request()->is('akademik*') ? 'active' : '' }}">Akademik</a></li>
                <li><a href="{{ url('/berita') }}" class="{{ request()->is('berita*') ? 'active' : '' }}">Berita</a></li>
                <li><a href="{{ url('/galeri') }}" class="{{ request()->is('galeri*') ? 'active' : '' }}">Galeri</a></li>
                <li><a href="{{ url('/prestasi') }}" class="{{ request()->is('prestasi*') ? 'active' : '' }}">Prestasi</a></li>
                <li><a href="{{ url('/kontak') }}" class="{{ request()->is('kontak*') ? 'active' : '' }}">Kontak</a></li>
            </ul>
        </nav>

        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ url('/ppdb') }}" class="btn-ppdb">SPMB 2026/2027</a>
            <button type="button" class="mobile-menu-btn" onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" style="display:none; background:none; border:none; font-size:24px; cursor:pointer; color:var(--color-ink);" aria-label="Buka Menu">
                ☰
            </button>
        </div>
    </div>

    <!-- Mobile Dropdown Navigation -->
    <div id="mobile-nav" class="hidden" style="background:var(--color-paper-alt); border-top:1px solid var(--color-line); padding:16px 24px;">
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:12px; font-weight:500;">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            <li><a href="{{ url('/profil') }}">Profil Sekolah</a></li>
            <li><a href="{{ url('/guru-staff') }}">Guru & Staf</a></li>
            <li><a href="{{ url('/akademik') }}">Akademik & Program</a></li>
            <li><a href="{{ url('/berita') }}">Berita & Artikel</a></li>
            <li><a href="{{ url('/galeri') }}">Galeri Foto & Video</a></li>
            <li><a href="{{ url('/prestasi') }}">Prestasi Siswa</a></li>
            <li><a href="{{ url('/kontak') }}">Hubungi Kami</a></li>
            <li style="padding-top:8px;"><a href="{{ url('/ppdb') }}" class="btn-ppdb" style="display:block; text-align:center;">Informasi SPMB Surabaya</a></li>
        </ul>
    </div>

    {{-- Teks Berjalan Pengumuman & Berita Penting --}}
    <div class="announcement-ticker" style="background: var(--color-navy-dark); color: #FFFFFF; border-top: 1px solid rgba(255,255,255,0.08); border-bottom: 1px solid var(--color-line); font-size: 13px; font-family: var(--font-mono); overflow: hidden; display: flex; align-items: center; height: 34px; position: relative;">
        <div style="background: var(--color-teal); color: #FFF; padding: 0 14px; height: 100%; display: flex; align-items: center; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; font-size: 11px; flex-shrink: 0; z-index: 2; box-shadow: 2px 0 6px rgba(0,0,0,0.25);">
            📢 PENGUMUMAN
        </div>
        <div class="ticker-content-wrap" style="flex: 1; overflow: hidden; white-space: nowrap; position: relative;">
            <div class="ticker-content" style="display: inline-block; padding-left: 100%; animation: ticker 32s linear infinite;">
                <span>{{ $runningText }}</span>
            </div>
        </div>
    </div>
</header>
