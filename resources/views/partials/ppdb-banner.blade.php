@php
    $isOpen = $ppdb && $ppdb->is_open;
    $academicYear = $ppdb->academic_year ?? '2026/2027';
    $regUrl = $ppdb->registration_url ?? 'https://ppdb.surabaya.go.id';
    $timelines = ($ppdb && $ppdb->timelines->isNotEmpty()) ? $ppdb->timelines->take(4) : collect([
        (object)['stage_name' => 'Validasi Data & Nilai Rapor', 'date_text' => 'Mei 2026', 'desc' => 'Daring via portal Dispendik Surabaya'],
        (object)['stage_name' => 'Pendaftaran Jalur Afirmasi & Mutasi', 'date_text' => 'Awal Juni 2026', 'desc' => 'Mitra warga, inklusi, dan tugas orang tua'],
        (object)['stage_name' => 'Pendaftaran Jalur Prestasi & Zonasi', 'date_text' => 'Pertengahan Juni 2026', 'desc' => 'Prestasi lomba, rapor, dan zonasi kelurahan'],
        (object)['stage_name' => 'Pengumuman & Daftar Ulang', 'date_text' => 'Awal Juli 2026', 'desc' => 'Verifikasi berkas fisik di sekolah'],
    ]);
@endphp

<section class="section section-alt">
    <div class="container">
        <div class="ppdb-banner">
            <div>
                @if($isOpen)
                    <span class="badge">PENDAFTARAN SPMB SEDANG DIBUKA</span>
                @else
                    <span class="badge badge-closed">INFORMASI SPMB TAHUN AJARAN {{ $academicYear }}</span>
                @endif
                <h2>Sistem Penerimaan Murid Baru (SPMB) SMP Kota Surabaya</h2>
                <p>
                    Penerimaan peserta didik baru SMP Negeri 14 Surabaya mengikuti mekanisme, sistem zonasi, dan jadwal terpadu Dinas Pendidikan Kota Surabaya. Seluruh calon siswa mendaftar melalui portal resmi SPMB Surabaya.
                </p>
                <div style="display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap;">
                    <a href="{{ url('/ppdb') }}" class="btn-on-dark">Info Persyaratan &amp; Jadwal</a>
                    <a href="{{ $regUrl }}" target="_blank" rel="noopener" class="btn-outline" style="border-color: #C9CEDA; color: #FBFAF5 !important;">
                        Portal Resmi SPMB Surabaya ↗
                    </a>
                </div>
            </div>
            <div style="text-align: right;">
                <div style="font-family: var(--font-mono); font-size: 13px; color: var(--color-gold); margin-bottom: 8px;">
                    JALUR UTAMA
                </div>
                <div style="font-size: 14px; color: #DDE2EE; line-height: 1.6; text-align: left;">
                    ✓ Jalur Afirmasi &amp; Inklusi<br>
                    ✓ Jalur Perpindahan Orang Tua<br>
                    ✓ Jalur Prestasi Rapor &amp; Lomba<br>
                    ✓ Jalur Zonasi Kelurahan
                </div>
            </div>
        </div>

        <div class="timeline">
            @foreach($timelines as $idx => $t)
                <div class="timeline-step">
                    <span class="step-num">0{{ $idx + 1 }}</span>
                    <h4>{{ $t->stage_name }}</h4>
                    <p>
                        @if(isset($t->start_date) && isset($t->end_date))
                            {{ $t->start_date->translatedFormat('d M') }} - {{ $t->end_date->translatedFormat('d M Y') }}
                        @else
                            {{ $t->desc ?? $t->date_text ?? 'Sesuai Juknis Resmi' }}
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
