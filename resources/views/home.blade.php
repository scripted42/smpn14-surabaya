@extends('layouts.app')

@section('title', ($settings['school_name'] ?? 'SMP Negeri 14 Surabaya') . ' — Beranda Resmi')
@section('meta_description', 'Kanal informasi resmi SMP Negeri 14 Surabaya. Informasi profil, akademik kelas VII-IX, kurikulum merdeka, berita sekolah, dan SPMB Kota Surabaya.')

@section('content')

    {{-- Hero Section --}}
    @include('partials.hero')

    {{-- Statistik Sekolah (Format Kolom Tabel / Kertas Ujian) --}}
    <section class="section" style="padding: 48px 0;">
        <div class="container">
            <div class="stats">
                @include('partials.stat-item', [
                    'number' => $settings['stat_students'] ?? '864',
                    'label' => 'Peserta Didik Kelas VII–IX'
                ])
                @include('partials.stat-item', [
                    'number' => $settings['stat_teachers'] ?? '52',
                    'label' => 'Dewan Guru & Tenaga Kependidikan'
                ])
                @include('partials.stat-item', [
                    'number' => $settings['stat_classes'] ?? '27 Rombel',
                    'label' => 'Rombongan Belajar'
                ])
            </div>
        </div>
    </section>

    {{-- Sambutan Kepala Sekolah --}}
    <section class="section section-alt">
        <div class="container principal">
            <div class="principal-photo">
                @if($principal && $principal->hasMedia('photo'))
                    <img src="{{ $principal->getFirstMediaUrl('photo', 'thumb') }}" alt="{{ $principal->name }}">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #E8EEF1; color: #50667D; font-family: var(--font-mono); font-size: 13px; text-align: center; padding: 12px;">
                        Foto Kepala Sekolah
                    </div>
                @endif
            </div>
            <div>
                <blockquote>
                    "{{ $settings['principal_quote'] ?? 'Sekolah bukan hanya tempat mengejar capaian nilai angka, tetapi ruang menempa karakter kejujuran, kecintaan terhadap literasi, dan tanggung jawab terhadap lingkungan hidup.' }}"
                </blockquote>
                <div class="name">{{ $settings['principal_name'] ?? ($principal?->name ?? 'Drs. H. Bambang Sutrisno, M.Pd.') }}</div>
                <div class="role">Kepala SMP Negeri 14 Surabaya {{ !empty($settings['principal_nip']) ? '· NIP. ' . $settings['principal_nip'] : '' }}</div>
            </div>
        </div>
    </section>

    {{-- Berita Sekolah Terbaru (6 Terbaru) --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="eyebrow-free-heading">Kabar &amp; Berita Sekolah</h2>
                    <p style="font-size: 14px; color: #5A6478; margin-top: 6px;">Kabar terbaru seputar dinamika belajar dan agenda SMPN 14 Surabaya</p>
                </div>
                <a href="{{ url('/berita') }}" class="link-all">Lihat semua berita</a>
            </div>

            <div class="news-grid">
                @forelse($news as $item)
                    @include('partials.news-card', ['news' => $item])
                @empty
                    <div style="grid-column: 1 / -1; padding: 48px; text-align: center; background: var(--color-paper-alt); border: 1px solid var(--color-line); font-family: var(--font-mono); color: #5A6478;">
                        Belum ada warta berita yang diterbitkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Program Unggulan Sekolah (Motif Tabel Jadwal Pelajaran Cetak) --}}
    <section class="section section-alt">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="eyebrow-free-heading">Program unggulan &amp; pembiasaan</h2>
                    <p style="font-size: 14px; color: #5A6478; margin-top: 6px;">Pengembangan kompetensi literasi, numerasi, karakter Profil Pelajar Pancasila</p>
                </div>
                <a href="{{ url('/akademik') }}" class="link-all">Rincian kurikulum</a>
            </div>

            <div style="overflow-x: auto;">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">KODE</th>
                            <th style="width: 240px;">PROGRAM</th>
                            <th>DESKRIPSI &amp; FOKUS PEMBIASAAN</th>
                            <th style="width: 140px;">JENJANG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="code">LIT-01</td>
                            <td style="font-weight: 600;">Gerakan Literasi Sekolah (GLS)</td>
                            <td>Pembiasaan membaca 15 menit setiap pagi, pojok baca tiap kelas, resensi buku mingguan, dan majalah dinding digital.</td>
                            <td>Kelas VII–IX</td>
                        </tr>
                        <tr>
                            <td class="code">ADW-02</td>
                            <td style="font-weight: 600;">Sekolah Adiwiyata &amp; Eco-School</td>
                            <td>Pengurangan sampah plastik, bank sampah mandiri, green house hidroponik, dan integrasi kurikulum ramah lingkungan hidup.</td>
                            <td>Kelas VII–IX</td>
                        </tr>
                        <tr>
                            <td class="code">TIK-03</td>
                            <td style="font-weight: 600;">Literasi Digital &amp; Koding Dasar</td>
                            <td>Praktik informatika, logika pemrograman Scratch/Python dasar, perakitan robotika, dan keamanan berinternet sehat.</td>
                            <td>Kelas VII–VIII</td>
                        </tr>
                        <tr>
                            <td class="code">P5-04</td>
                            <td style="font-weight: 600;">Projek Profil Pelajar Pancasila</td>
                            <td>Projek kolaboratif berorientasi aksi: Kearifan Lokal Arek Suroboyo, Suara Demokrasi, dan Kewirausahaan Berkelanjutan.</td>
                            <td>Kelas VII &amp; VIII</td>
                        </tr>
                        <tr>
                            <td class="code">BIM-05</td>
                            <td style="font-weight: 600;">Klinik Prestasi Sains &amp; Bahasa</td>
                            <td>Bimbingan intensif sore hari untuk persiapan kompetisi OSN, FLS2N, O2SN, serta persiapan tes masuk jenjang SMA/SMK.</td>
                            <td>Kelas VIII &amp; IX</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Fasilitas Penunjang Belajar --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="eyebrow-free-heading">Fasilitas penunjang belajar</h2>
                    <p style="font-size: 14px; color: #5A6478; margin-top: 6px;">Sarana prasarana modern untuk mendukung pembelajaran interaktif</p>
                </div>
                <a href="{{ url('/profil') }}#fasilitas" class="link-all">Seluruh fasilitas</a>
            </div>

            <div class="facility-grid">
                @forelse($facilities as $fac)
                    @php
                        $photoUrl = $fac->getFirstMediaUrl('photo', 'thumb') ?: ($fac->photo_path ? asset('storage/' . $fac->photo_path) : null);
                    @endphp
                    <div class="facility">
                        <div class="facility-photo">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $fac->name }}" loading="lazy">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #E8EEF1; color: #50667D; font-family: var(--font-mono); font-size: 12px; text-align: center; padding: 8px;">
                                    {{ $fac->name }}
                                </div>
                            @endif
                        </div>
                        <div class="facility-body">
                            <h4>{{ $fac->name }}</h4>
                            <p>{{ Str::limit($fac->description, 80) }}</p>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; padding: 24px; text-align: center;">Fasilitas sedang disiapkan.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Banner PPDB / SPMB Kota Surabaya & Timeline --}}
    @include('partials.ppdb-banner', ['ppdb' => $ppdb])

    {{-- Testimoni Siswa, Orang Tua, & Alumni --}}
    <section class="section">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="eyebrow-free-heading">Suara siswa, orang tua, &amp; alumni</h2>
                    <p style="font-size: 14px; color: #5A6478; margin-top: 6px;">Pengalaman nyata menjalani proses belajar dan bertumbuh di SMPN 14</p>
                </div>
            </div>

            <div class="testimonial-grid">
                @forelse($testimonials as $testi)
                    @php
                        $avatarUrl = $testi->getFirstMediaUrl('photo', 'thumb') ?: ($testi->photo_path ? asset('storage/' . $testi->photo_path) : null);
                        $roleLabel = match($testi->role) {
                            'siswa' => 'Peserta Didik',
                            'orang_tua' => 'Orang Tua Murid',
                            'alumni' => 'Alumni SMPN 14',
                            default => ucfirst($testi->role),
                        };
                    @endphp
                    <div class="testimonial">
                        <p class="quote">"{{ $testi->content }}"</p>
                        <div class="who">
                            <div class="avatar">
                                @if($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="{{ $testi->name }}">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: var(--color-teal); color: #FFFFFF; font-weight: bold; font-size: 13px;">
                                        {{ substr($testi->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="name">{{ $testi->name }}</div>
                                <div class="role">{{ $roleLabel }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; padding: 24px; text-align: center;">Belum ada testimoni yang disetujui.</div>
                @endforelse
            </div>
        </div>
    </section>

@endsection
