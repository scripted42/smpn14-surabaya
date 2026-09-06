@extends('layouts.app')

@section('title', 'Galeri Dokumentasi Kegiatan — SMP Negeri 14 Surabaya')
@section('meta_description', 'Dokumentasi foto dan video kegiatan belajar mengajar, upacara peringatan hari nasional, gelar karya P5, dan lomba siswa SMPN 14 Surabaya.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Galeri Dokumentasi']
    ]
])

<section class="section">
    <div class="container">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 24px; margin-bottom: 36px;">
            <span class="badge-mono badge-neutral" style="margin-bottom: 8px;">Arsip Visual Sekolah</span>
            <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                Galeri Foto & Video Kegiatan
            </h1>
            <p class="lead" style="margin-top: 8px; margin-bottom: 0;">
                Kilas balik momen kebersamaan, peringatan hari besar, kegiatan ekstrakurikuler, dan gelar prestasi warga SMPN 14 Surabaya.
            </p>
        </div>

        @if($galleries->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                @foreach($galleries as $gallery)
                    @php
                        $coverUrl = $gallery->getFirstMediaUrl('cover') 
                                    ?: ($gallery->cover_path ? (str_starts_with($gallery->cover_path, 'http') ? $gallery->cover_path : asset('storage/' . $gallery->cover_path)) : null);
                        $photoCount = $gallery->photos->count();
                        $videoCount = $gallery->videos->count();
                    @endphp
                    <article style="background: var(--color-paper-alt); border: 1px solid var(--color-line); border-radius: 2px; overflow: hidden; display: flex; flex-direction: column;">
                        <!-- Album Cover -->
                        <a href="{{ route('gallery.show', $gallery->slug) }}" style="position: relative; height: 200px; display: block; background: #D8D3BF; border-bottom: 1px solid var(--color-line); overflow: hidden;">
                            @if($coverUrl)
                                <img src="{{ $coverUrl }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-family: var(--font-mono); font-size: 13px; color: #5C6A79;">
                                    Album Kegiatan
                                </div>
                            @endif
                            <div style="position: absolute; bottom: 8px; right: 8px; display: flex; gap: 4px;">
                                @if($photoCount > 0)
                                    <span class="badge-mono badge-neutral" style="background: rgba(31,42,68,0.85); color: #fff; border: none; font-size: 11px;">
                                        📷 {{ $photoCount }} Foto
                                    </span>
                                @endif
                                @if($videoCount > 0)
                                    <span class="badge-mono badge-red" style="font-size: 11px;">
                                        ▶ {{ $videoCount }} Video
                                    </span>
                                @endif
                            </div>
                        </a>

                        <!-- Album Info -->
                        <div style="padding: 16px; flex: 1; display: flex; flex-direction: column;">
                            <time style="font-family: var(--font-mono); font-size: 12px; color: #5C6A79; margin-bottom: 6px; display: block;">
                                {{ $gallery->event_date ? $gallery->event_date->translatedFormat('d F Y') : 'Dokumentasi' }}
                            </time>
                            <h3 style="font-size: 17px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3;">
                                <a href="{{ route('gallery.show', $gallery->slug) }}" style="color: var(--color-ink);">
                                    {{ $gallery->title }}
                                </a>
                            </h3>
                            @if($gallery->description)
                                <p style="font-size: 14px; color: #4A5568; line-height: 1.5; margin: 0 0 12px 0;">
                                    {{ Str::limit($gallery->description, 100) }}
                                </p>
                            @endif
                            <div style="margin-top: auto; padding-top: 10px; border-top: 1px dashed var(--color-line);">
                                <a href="{{ route('gallery.show', $gallery->slug) }}" style="font-family: var(--font-mono); font-size: 13px; font-weight: 600; color: var(--color-ink); text-decoration: underline;">
                                    Buka Album Lengkap →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            {{ $galleries->links('partials.pagination') }}
        @else
            <div style="background: var(--color-paper-alt); border: 1px dashed var(--color-line); padding: 48px; text-align: center; border-radius: 2px;">
                <p style="font-size: 18px; color: #5C6A79; margin: 0;">Belum ada album galeri yang dipublikasikan.</p>
            </div>
        @endif
    </div>
</section>

@endsection
