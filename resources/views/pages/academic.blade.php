@extends('layouts.app')

@section('title', 'Kurikulum & Program Akademik — SMP Negeri 14 Surabaya')
@section('meta_description', 'Implementasi Kurikulum Merdeka jenjang SMP, Projek Penguatan Profil Pelajar Pancasila (P5), dan kegiatan ekstrakurikuler siswa.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Akademik & Program']
    ]
])

<!-- Header -->
<section class="section" style="padding-bottom: 32px;">
    <div class="container">
        <div style="border-left: 4px solid var(--color-red); padding-left: 20px; margin-bottom: 32px;">
            <span class="badge-mono badge-neutral" style="margin-bottom: 8px;">Jenjang Kelas VII, VIII, IX</span>
            <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                Kurikulum & Ekstrakurikuler
            </h1>
            <p class="lead" style="margin-top: 8px; margin-bottom: 0;">
                Struktur pembelajaran Kurikulum Merdeka yang adaptif dan holistik, didukung wadah pengembangan minat dan bakat non-akademik peserta didik.
            </p>
        </div>

        <div class="filter-tabs" style="margin-bottom: 0;">
            <a href="#kurikulum" class="filter-tab">1. Kurikulum Merdeka</a>
            <a href="#ekskul" class="filter-tab">2. Daftar Ekstrakurikuler</a>
        </div>
    </div>
</section>

<!-- Section 1: Kurikulum Merdeka -->
<section id="kurikulum" class="section section-alt">
    <div class="container" style="max-width: 960px;">
        <div style="display: flex; align-items: baseline; gap: 12px; border-bottom: 2px solid var(--color-ink); padding-bottom: 8px; margin-bottom: 24px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">01.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 0; color: var(--color-ink);">
                {{ $kurikulum?->title ?? 'Kurikulum Pembelajaran' }}
            </h2>
        </div>

        <div class="article-content" style="font-size: 16px; line-height: 1.8;">
            @if($kurikulum)
                {!! $kurikulum->content !!}
            @else
                <p>Informasi kurikulum sekolah sedang dalam pemutakhiran.</p>
            @endif
        </div>
    </div>
</section>

<!-- Section 2: Ekstrakurikuler (Gaya Tabel Jadwal & Rapor) -->
<section id="ekskul" class="section">
    <div class="container">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 12px; margin-bottom: 32px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">02.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 4px 0 8px 0; color: var(--color-ink);">
                Wadah Pengembangan Minat & Bakat (Ekstrakurikuler)
            </h2>
            <p class="lead" style="margin: 0; font-size: 16px;">
                Peserta didik dapat memilih minimal satu ekstrakurikuler pilihan di samping ekstrakurikuler wajib Pramuka Penggalang.
            </p>
        </div>

        <!-- Tabel Jadwal & Informasi Ekskul -->
        <div style="overflow-x: auto;">
            <table class="table-rapor">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No.</th>
                        <th style="width: 240px;">Nama Ekstrakurikuler</th>
                        <th>Deskripsi & Fokus Pembinaan</th>
                        <th style="width: 220px;">Pembina / Pelatih</th>
                        <th style="width: 200px;">Jadwal Latihan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($extracurriculars as $index => $ekskul)
                        <tr>
                            <td style="text-align: center; font-family: var(--font-mono); font-weight: 600; color: var(--color-ink);">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td>
                                <strong style="color: var(--color-ink); font-size: 16px;">{{ $ekskul->name }}</strong>
                            </td>
                            <td style="color: #3C4A63;">
                                {{ $ekskul->description }}
                            </td>
                            <td style="font-size: 14px; color: var(--color-ink);">
                                {{ $ekskul->coach_name ?? 'Dewan Guru Pembina' }}
                            </td>
                            <td style="font-family: var(--font-mono); font-size: 13px; color: var(--color-red);">
                                {{ $ekskul->schedule_text ?? 'Sesuai Jadwal Rombel' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: #5C6A79;">
                                Data ekstrakurikuler sedang diperbarui untuk semester ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
