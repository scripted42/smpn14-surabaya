@php
    $schoolName = $settings['school_name'] ?? 'SMP Negeri 14 Surabaya';
    $address = $settings['address'] ?? 'Jl. Jurang Kuping, Kel. Benowo, Kec. Pakal, Kota Surabaya, Jawa Timur 60195';
    $phone = $settings['phone'] ?? '(031) 7405230';
    $email = $settings['email'] ?? 'info@smpn14surabaya.sch.id';
    $hours = $settings['operational_hours'] ?? 'Senin - Jumat: 06.30 - 15.30 WIB';
    $ig = $settings['social_instagram'] ?? 'https://instagram.com';
    $yt = $settings['social_youtube'] ?? 'https://youtube.com';
    $fb = $settings['social_facebook'] ?? 'https://facebook.com';
    $footerLogo = !empty($settings['school_logo']) 
        ? (str_starts_with($settings['school_logo'], 'images/') ? asset($settings['school_logo']) : asset('storage/' . $settings['school_logo']))
        : asset('images/logo-smpn14.png');
@endphp

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <img src="{{ $footerLogo }}" alt="Logo {{ $schoolName }}" style="width: 38px; height: 38px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));">
                    <h5 style="margin: 0; font-size: 15px;">{{ strtoupper($schoolName) }}</h5>
                </div>
                <p style="font-size:14px; max-width:34ch; color:#C9D6CC; margin-bottom: 12px; line-height: 1.5;">
                    {{ $address }}
                </p>
                <div style="font-family: var(--font-mono); font-size: 12px; color: #A9C2AE;">
                    NPSN: {{ $settings['npsn'] ?? '20532552' }} · Sekolah Menengah Pertama Negeri
                </div>
            </div>

            <div>
                <h5>NAVIGASI UTAMA</h5>
                <ul>
                    <li><a href="{{ url('/profil') }}">Profil & Visi Misi</a></li>
                    <li><a href="{{ url('/guru-staff') }}">Direktori Guru & Staf</a></li>
                    <li><a href="{{ url('/akademik') }}">Kurikulum & Program</a></li>
                    <li><a href="{{ url('/ppdb') }}">Info SPMB Surabaya</a></li>
                </ul>
            </div>

            <div>
                <h5>INFORMASI PUBLIK</h5>
                <ul>
                    <li><a href="{{ url('/berita') }}">Berita & Kegiatan</a></li>
                    <li><a href="{{ url('/prestasi') }}">Prestasi Kejuaraan</a></li>
                    <li><a href="{{ url('/galeri') }}">Dokumentasi Galeri</a></li>
                    <li><a href="{{ url('/kontak') }}">Layanan Kontak</a></li>
                </ul>
            </div>

            <div>
                <h5>HUBUNGI SEKOLAH</h5>
                <ul>
                    <li style="font-family: var(--font-mono); font-size: 13px;">{{ $phone }}</li>
                    <li><a href="mailto:{{ $email }}" style="font-family: var(--font-mono); font-size: 13px;">{{ $email }}</a></li>
                    <li style="font-size: 13px; color: #A9C2AE; margin-top: 6px;">{{ $hours }}</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} {{ $schoolName }}. Hak Cipta Dilindungi.</span>
            <div style="display: flex; gap: 16px;">
                @if($ig)<a href="{{ $ig }}" target="_blank" rel="noopener">Instagram</a>@endif
                @if($yt)<a href="{{ $yt }}" target="_blank" rel="noopener">YouTube</a>@endif
                @if($fb)<a href="{{ $fb }}" target="_blank" rel="noopener">Facebook</a>@endif
            </div>
        </div>
    </div>
</footer>
