@extends('layouts.app')

@section('title', 'Profil Sekolah — SMP Negeri 14 Surabaya')
@section('meta_description', 'Sejarah, Visi, Misi, Budaya Sekolah, dan Struktur Kepemimpinan Resmi SMP Negeri 14 Surabaya.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Profil Sekolah']
    ]
])

<!-- Section Header -->
<section class="section" style="padding-bottom: 32px;">
    <div class="container">
        <div style="border-left: 4px solid var(--color-red); padding-left: 20px; margin-bottom: 32px;">
            <span class="badge-mono badge-neutral" style="margin-bottom: 8px;">Mengenal Lebih Dekat</span>
            <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                Profil SMP Negeri 14 Surabaya
            </h1>
            <p class="lead" style="margin-top: 8px; margin-bottom: 0;">
                Institusi pendidikan menengah pertama negeri di bawah naungan Dinas Pendidikan Kota Surabaya yang berdedikasi mewujudkan generasi cerdas, berkarakter luhur, dan peduli kelestarian alam.
            </p>
        </div>

        <!-- Tab/Navigasi Cepat Halaman -->
        <div class="filter-tabs" style="margin-bottom: 0;">
            <a href="#sejarah" class="filter-tab">1. Sejarah Singkat</a>
            <a href="#visi-misi" class="filter-tab">2. Visi & Misi</a>
            <a href="#struktur" class="filter-tab">3. Pimpinan Struktural</a>
            <a href="#tata-tertib" class="filter-tab">4. Tata Tertib Siswa</a>
        </div>
    </div>
</section>

<!-- Section 1: Sejarah -->
<section id="sejarah" class="section section-alt">
    <div class="container" style="max-width: 960px;">
        <div style="display: flex; align-items: baseline; gap: 12px; border-bottom: 2px solid var(--color-ink); padding-bottom: 8px; margin-bottom: 24px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">01.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 0; color: var(--color-ink);">
                {{ $sejarah?->title ?? 'Sejarah Sekolah' }}
            </h2>
        </div>

        <div class="article-content" style="font-size: 16px; line-height: 1.8;">
            @if($sejarah)
                {!! $sejarah->content !!}
            @else
                <p>Informasi sejarah sekolah sedang dalam proses pemutakhiran arsip dokumentasi resmi.</p>
            @endif
        </div>
    </div>
</section>

<!-- Section 2: Visi & Misi -->
<section id="visi-misi" class="section">
    <div class="container" style="max-width: 960px;">
        <div style="display: flex; align-items: baseline; gap: 12px; border-bottom: 2px solid var(--color-ink); padding-bottom: 8px; margin-bottom: 24px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">02.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 0; color: var(--color-ink);">
                {{ $visiMisi?->title ?? 'Visi dan Misi' }}
            </h2>
        </div>

        <div class="article-content" style="font-size: 16px; line-height: 1.8;">
            @if($visiMisi)
                {!! $visiMisi->content !!}
            @else
                <p>Visi dan Misi sekolah sedang dalam pemutakhiran kurikulum merdeka.</p>
            @endif
        </div>
    </div>
</section>

<!-- Section 3: Struktur Organisasi / Pimpinan Struktural -->
<section id="struktur" class="section section-alt">
    <div class="container">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 12px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
            <div>
                <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">03.</span>
                <h2 style="font-family: var(--font-display); font-size: 28px; margin: 4px 0 0 0; color: var(--color-ink);">
                    Struktur Pimpinan Sekolah
                </h2>
            </div>
            <a href="{{ route('teachers.index') }}" class="btn btn-outline" style="font-size: 14px;">
                Lihat Seluruh Dewan Guru & Staf →
            </a>
        </div>

        <!-- Cards Pimpinan -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
            @foreach($structuralTeachers as $teacher)
                @php
                    $photoUrl = $teacher->getFirstMediaUrl('photo', 'thumb')
                                ?: ($teacher->photo_path ? (str_starts_with($teacher->photo_path, 'http') ? $teacher->photo_path : asset('storage/' . $teacher->photo_path)) : null);
                @endphp
                <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 20px; border-radius: 2px;">
                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 80px; height: 96px; flex-shrink: 0; background: #D6D2C0; border: 1px solid var(--color-line); overflow: hidden; border-radius: 2px;">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $teacher->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #7B8599;">
                                    👤
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <span class="badge-mono badge-red" style="font-size: 11px; margin-bottom: 4px;">
                                {{ $teacher->position }}
                            </span>
                            <h3 style="font-size: 17px; font-weight: 700; margin: 4px 0 2px 0; color: var(--color-ink); line-height: 1.3;">
                                {{ $teacher->name }}
                            </h3>
                            @if($teacher->nip)
                                <div style="font-family: var(--font-mono); font-size: 12px; color: #5C6A79;">
                                    NIP. {{ $teacher->nip }}
                                </div>
                            @endif
                            @if($teacher->subject)
                                <div style="font-size: 13px; color: #3C4A63; margin-top: 4px;">
                                    Ampuan: {{ $teacher->subject }}
                                </div>
                            @endif
                        </div>
                    </div>
                    @if($teacher->bio)
                        <p style="margin: 14px 0 0 0; font-size: 14px; color: #4A5568; line-height: 1.5; border-top: 1px dashed var(--color-line); padding-top: 10px;">
                            {{ $teacher->bio }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Section 4: Tata Tertib Siswa -->
@if($tataTertib)
<section id="tata-tertib" class="section">
    <div class="container" style="max-width: 960px;">
        <div style="display: flex; align-items: baseline; gap: 12px; border-bottom: 2px solid var(--color-ink); padding-bottom: 8px; margin-bottom: 24px;">
            <span style="font-family: var(--font-mono); font-size: 16px; font-weight: 700; color: var(--color-red);">04.</span>
            <h2 style="font-family: var(--font-display); font-size: 28px; margin: 0; color: var(--color-ink);">
                {{ $tataTertib->title }}
            </h2>
        </div>

        <div class="article-content" style="font-size: 16px; line-height: 1.8;">
            {!! $tataTertib->content !!}
        </div>
    </div>
</section>
@endif

@endsection
