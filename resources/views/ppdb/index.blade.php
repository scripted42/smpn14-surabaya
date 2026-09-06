@extends('layouts.app')

@section('title', 'Informasi SPMB & PPDB 2026/2027 — SMP Negeri 14 Surabaya')
@section('meta_description', 'Panduan resmi persyaratan, jalur seleksi zonasi, jadwal tahapan, dan FAQ pendaftaran siswa baru SMP Negeri 14 Surabaya melalui SPMB Dispendik Surabaya.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Informasi PPDB / SPMB']
    ]
])

<!-- Hero Banner PPDB -->
<section class="section" style="padding-bottom: 40px;">
    <div class="container">
        <div style="border-left: 4px solid var(--color-red); padding-left: 20px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span class="badge-mono {{ $ppdb?->is_open ? 'badge-red' : 'badge-neutral' }}">
                    {{ $ppdb?->is_open ? 'PENDAFTARAN DIBUKA' : 'PENDAFTARAN DITUTUP' }}
                </span>
                <span style="font-family: var(--font-mono); font-size: 13px; color: #5C6A79;">
                    Tahun Ajaran {{ $ppdb?->academic_year ?? '2026/2027' }}
                </span>
            </div>
            <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                Penerimaan Murid Baru (SPMB) SMP Negeri 14 Surabaya
            </h1>
            <p class="lead" style="margin-top: 12px; margin-bottom: 0;">
                {{ $ppdb?->intro_text ?? 'Penerimaan Peserta Didik Baru (PPDB) SMP Negeri di Kota Surabaya dilaksanakan secara terpusat, transparan, dan terpadu melalui sistem SPMB daring Dinas Pendidikan Kota Surabaya.' }}
            </p>
        </div>

        <!-- CTA Box Link Luar ke SPMB Surabaya -->
        <div style="background: var(--color-paper-alt); border: 2px solid var(--color-ink); padding: 24px 28px; border-radius: 2px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-top: 24px;">
            <div>
                <h2 style="font-family: var(--font-display); font-size: 20px; margin: 0 0 6px 0; color: var(--color-ink);">
                    Portal Resmi SPMB Kota Surabaya
                </h2>
                <p style="margin: 0; font-size: 14px; color: #4A5568; max-width: 60ch;">
                    Seluruh proses pendaftaran akun, pemilihan jalur zonasi/afirmasi/prestasi, serta unggah berkas dilakukan langsung di situs resmi Pemerintah Kota Surabaya.
                </p>
            </div>
            <a href="{{ $ppdb?->registration_url ?? 'https://ppdb.surabaya.go.id' }}" target="_blank" rel="noopener noreferrer" class="btn" style="background: var(--color-red); color: #fff; padding: 12px 24px; font-size: 15px; font-weight: 600; white-space: nowrap;">
                Buka Portal SPMB Surabaya ↗
            </a>
        </div>
    </div>
</section>

<!-- Section 1: Linimasa / Jadwal Tahapan Seleksi -->
<section class="section section-alt">
    <div class="container">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 12px; margin-bottom: 32px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">01.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 4px 0 8px 0; color: var(--color-ink);">
                Jadwal & Linimasa Tahapan Seleksi
            </h2>
            <p class="lead" style="margin: 0; font-size: 16px;">
                Harap perhatikan rentang tanggal pelaksanaan setiap jalur pendaftaran secara teliti agar tidak terlambat.
            </p>
        </div>

        @if($ppdb && $ppdb->timelines->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table-rapor">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">Tahap</th>
                            <th>Uraian Kegiatan / Jalur Seleksi</th>
                            <th style="width: 220px;">Tanggal Mulai</th>
                            <th style="width: 220px;">Tanggal Berakhir</th>
                            <th style="width: 140px; text-align: center;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ppdb->timelines as $index => $timeline)
                            @php
                                $today = now()->startOfDay();
                                $startDate = \Carbon\Carbon::parse($timeline->start_date)->startOfDay();
                                $endDate = \Carbon\Carbon::parse($timeline->end_date)->endOfDay();
                                $isOngoing = $today->between($startDate, $endDate);
                                $isPast = $today->isAfter($endDate);
                            @endphp
                            <tr style="{{ $isOngoing ? 'background: #FAF3E6;' : '' }}">
                                <td style="text-align: center; font-family: var(--font-mono); font-weight: 700; color: var(--color-ink);">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    <strong style="color: var(--color-ink); font-size: 15px;">{{ $timeline->stage_name }}</strong>
                                    @if($isOngoing)
                                        <span class="badge-mono badge-red" style="margin-left: 8px; font-size: 10px;">Berlangsung</span>
                                    @endif
                                </td>
                                <td style="font-family: var(--font-mono); font-size: 14px; color: var(--color-ink);">
                                    {{ \Carbon\Carbon::parse($timeline->start_date)->translatedFormat('d F Y') }}
                                </td>
                                <td style="font-family: var(--font-mono); font-size: 14px; color: var(--color-ink);">
                                    {{ \Carbon\Carbon::parse($timeline->end_date)->translatedFormat('d F Y') }}
                                </td>
                                <td style="text-align: center;">
                                    @if($isPast)
                                        <span class="badge-mono badge-neutral" style="font-size: 10px;">Selesai</span>
                                    @elseif($isOngoing)
                                        <span class="badge-mono badge-gold" style="font-size: 10px;">Aktif</span>
                                    @else
                                        <span class="badge-mono badge-neutral" style="font-size: 10px;">Mendatang</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="color: #5C6A79;">Jadwal tahapan resmi sedang disinkronkan dengan petunjuk teknis Dispendik Kota Surabaya.</p>
        @endif
    </div>
</section>

<!-- Section 2: Persyaratan Berkas -->
<section class="section">
    <div class="container" style="max-width: 960px;">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 12px; margin-bottom: 24px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">02.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 4px 0 0 0; color: var(--color-ink);">
                Persyaratan Calon Peserta Didik Baru
            </h2>
        </div>

        <div class="article-content" style="font-size: 16px; line-height: 1.8; background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 28px; border-radius: 2px;">
            @if($ppdb && $ppdb->requirements)
                {!! $ppdb->requirements !!}
            @else
                <p>Ketentuan persyaratan pendaftaran belum dimuat.</p>
            @endif
        </div>
    </div>
</section>

<!-- Section 3: FAQ Accordion -->
<section class="section section-alt">
    <div class="container" style="max-width: 960px;">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 12px; margin-bottom: 32px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">03.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 4px 0 8px 0; color: var(--color-ink);">
                Pertanyaan yang Sering Diajukan (FAQ)
            </h2>
            <p class="lead" style="margin: 0; font-size: 16px;">
                Jawaban seputar kendala teknis, zonasi domisili, dan berkas verifikasi PPDB.
            </p>
        </div>

        @if($ppdb && $ppdb->faqs->count() > 0)
            <div class="faq-list">
                @foreach($ppdb->faqs as $faq)
                    <div class="accordion-item">
                        <button type="button" class="accordion-header" onclick="toggleFaq(this)">
                            <span>{{ $faq->question }}</span>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" style="display: none;">
                            <p style="margin: 0;">{{ $faq->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #5C6A79;">Belum ada daftar pertanyaan yang dipublikasikan.</p>
        @endif

        <!-- Bantuan Meja Helpdesk -->
        <div style="margin-top: 36px; padding: 20px; border: 1px dashed var(--color-line); background: var(--color-paper); border-radius: 2px;">
            <h3 style="font-size: 17px; margin: 0 0 6px 0; color: var(--color-ink);">Mengalami Kendala Validasi atau Butuh Informasi Langsung?</h3>
            <p style="margin: 0 0 12px 0; font-size: 14px; color: #4A5568;">
                Tim Meja Bantuan (Helpdesk) SMP Negeri 14 Surabaya membuka posko pendampingan di ruang Tata Usaha setiap hari kerja (Senin - Jumat pukul 08.00 - 14.00 WIB).
            </p>
            <a href="{{ route('contact.index') }}" class="btn btn-outline" style="font-size: 14px;">Hubungi Tim Helpdesk Sekolah</a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    function toggleFaq(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('.accordion-icon');
        const isHidden = content.style.display === 'none';

        // Close other accordions for neatness
        document.querySelectorAll('.accordion-content').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.accordion-icon').forEach(el => {
            el.textContent = '+';
            el.style.transform = 'rotate(0deg)';
        });

        if (isHidden) {
            content.style.display = 'block';
            icon.textContent = '−';
        } else {
            content.style.display = 'none';
            icon.textContent = '+';
        }
    }
</script>
@endpush

@endsection
