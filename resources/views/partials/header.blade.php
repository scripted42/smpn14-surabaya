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
                
                {{-- Dropdown Menu Aplikasi --}}
                <li class="nav-dropdown" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button type="button" class="nav-dropdown-btn" :class="{ 'active': open }" @click="open = !open" aria-expanded="false" aria-haspopup="true">
                        <span>Aplikasi</span>
                        <svg class="dropdown-arrow" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    
                    <div class="nav-dropdown-panel" x-show="open" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" style="display:none;">
                        <div class="dropdown-header">Aplikasi & Layanan Digital</div>
                        
                        {{-- 1. Presensia --}}
                        <a href="https://presensia.smpn14-surabaya.sch.id" target="_blank" rel="noopener noreferrer" class="dropdown-item active-app" title="Buka Presensia SMPN 14 Surabaya">
                            <div class="app-icon" style="background: var(--color-teal-bg); color: var(--color-teal);">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                    <path d="m9 16 2 2 4-4"></path>
                                </svg>
                            </div>
                            <div class="app-info">
                                <div class="app-title-row">
                                    <span class="app-name">Presensia</span>
                                    <span class="badge-online">Online</span>
                                </div>
                                <div class="app-desc">Presensi digital siswa & guru</div>
                            </div>
                            <svg class="app-ext-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h4a.75.75 0 010 1.5h-4z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06 1.06l7.996-7.996V8.25a.75.75 0 001.5 0V3.75a.75.75 0 00-.75-.75H11.5a.75.75 0 000 1.5h2.438l-7.744 7.503z" clip-rule="evenodd" />
                            </svg>
                        </a>

                        {{-- 2. Jurnal Mengajar --}}
                        <div class="dropdown-item coming-soon" title="Segera Hadir">
                            <div class="app-icon" style="background: #F1F5F9; color: #64748B;">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                </svg>
                            </div>
                            <div class="app-info">
                                <div class="app-title-row">
                                    <span class="app-name">Jurnal Mengajar</span>
                                    <span class="badge-soon">Coming Soon</span>
                                </div>
                                <div class="app-desc">Agenda & catatan KBM guru</div>
                            </div>
                        </div>

                        {{-- 3. Perpustakaan --}}
                        <div class="dropdown-item coming-soon" title="Segera Hadir">
                            <div class="app-icon" style="background: #F1F5F9; color: #64748B;">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m16 6 4 14"></path>
                                    <path d="M12 6v14"></path>
                                    <path d="M8 8v12"></path>
                                    <path d="M4 4v16"></path>
                                </svg>
                            </div>
                            <div class="app-info">
                                <div class="app-title-row">
                                    <span class="app-name">Perpustakaan</span>
                                    <span class="badge-soon">Coming Soon</span>
                                </div>
                                <div class="app-desc">Katalog buku & pustaka digital</div>
                            </div>
                        </div>

                        {{-- 4. E-Rapor --}}
                        <div class="dropdown-item coming-soon" title="Segera Hadir">
                            <div class="app-icon" style="background: #F1F5F9; color: #64748B;">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div class="app-info">
                                <div class="app-title-row">
                                    <span class="app-name">E-Rapor</span>
                                    <span class="badge-soon">Coming Soon</span>
                                </div>
                                <div class="app-desc">Penilaian capaian belajar siswa</div>
                            </div>
                        </div>

                        {{-- 5. E-Lapor --}}
                        <div class="dropdown-item coming-soon" title="Segera Hadir">
                            <div class="app-icon" style="background: #F1F5F9; color: #64748B;">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                            </div>
                            <div class="app-info">
                                <div class="app-title-row">
                                    <span class="app-name">E-Lapor</span>
                                    <span class="badge-soon">Coming Soon</span>
                                </div>
                                <div class="app-desc">Aspirasi & pengaduan sekolah</div>
                            </div>
                        </div>
                    </div>
                </li>

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
            
            <li style="padding: 10px 0; border-top: 1px dashed var(--color-line); border-bottom: 1px dashed var(--color-line);">
                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--color-teal); letter-spacing: 0.8px; margin-bottom: 8px;">
                    Aplikasi Sekolah
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px; padding-left: 2px;">
                    <a href="https://presensia.smpn14-surabaya.sch.id" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; color: var(--color-ink); text-decoration: none;">
                        <span style="font-weight: 600;">1. Presensia</span>
                        <span style="background: var(--color-teal-bg); color: var(--color-teal); font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 4px; border: 1px solid rgba(27, 118, 112, 0.2);">Online ↗</span>
                    </a>
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; color: #8C99A8;">
                        <span>2. Jurnal Mengajar</span>
                        <span style="background: #F1F5F9; color: #64748B; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px;">Coming Soon</span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; color: #8C99A8;">
                        <span>3. Perpustakaan</span>
                        <span style="background: #F1F5F9; color: #64748B; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px;">Coming Soon</span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; color: #8C99A8;">
                        <span>4. E-Rapor</span>
                        <span style="background: #F1F5F9; color: #64748B; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px;">Coming Soon</span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; color: #8C99A8;">
                        <span>5. E-Lapor</span>
                        <span style="background: #F1F5F9; color: #64748B; font-size: 10px; font-weight: 600; padding: 2px 6px; border-radius: 4px;">Coming Soon</span>
                    </div>
                </div>
            </li>

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
