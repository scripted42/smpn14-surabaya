@extends('layouts.app')

@section('title', $gallery->title . ' — Galeri SMP Negeri 14 Surabaya')
@section('meta_description', Str::limit(strip_tags($gallery->description ?: 'Album foto dan dokumentasi kegiatan sekolah SMP Negeri 14 Surabaya'), 150))

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Galeri', 'url' => route('gallery.index')],
        ['label' => Str::limit($gallery->title, 40)]
    ]
])

<article class="section" style="padding-top: 40px;">
    <div class="container">
        
        <!-- Header Album -->
        <header style="border-bottom: 2px solid var(--color-ink); padding-bottom: 24px; margin-bottom: 36px;">
            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
                <span class="badge-mono badge-neutral">Album Dokumentasi</span>
                <time style="font-family: var(--font-mono); font-size: 13px; color: #5C6A79;">
                    {{ $gallery->event_date ? $gallery->event_date->translatedFormat('d F Y') : 'SMPN 14 Surabaya' }}
                </time>
            </div>
            <h1 class="eyebrow-free-heading" style="margin: 0 0 12px 0;">
                {{ $gallery->title }}
            </h1>
            @if($gallery->description)
                <p class="lead" style="margin: 0;">
                    {{ $gallery->description }}
                </p>
            @endif
        </header>

        <!-- Galeri Foto dengan Lightbox -->
        <div style="margin-bottom: 48px;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 20px; border-bottom: 1px solid var(--color-line); padding-bottom: 8px;">
                <h2 style="font-family: var(--font-display); font-size: 22px; margin: 0; color: var(--color-ink);">
                    Dokumentasi Foto ({{ $gallery->photos->count() }})
                </h2>
                <span style="font-family: var(--font-mono); font-size: 12px; color: #5C6A79;">
                    Klik foto untuk memperbesar
                </span>
            </div>

            @if($gallery->photos->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px;">
                    @foreach($gallery->photos as $photo)
                        @php
                            $photoUrl = $photo->getFirstMediaUrl('photo') 
                                        ?: ($photo->photo_path ? (str_starts_with($photo->photo_path, 'http') ? $photo->photo_path : asset('storage/' . $photo->photo_path)) : null);
                        @endphp
                        <figure style="margin: 0; background: var(--color-paper-alt); border: 1px solid var(--color-line); border-radius: 2px; overflow: hidden; cursor: pointer;"
                                onclick="openLightbox('{{ $photoUrl }}', '{{ addslashes($photo->caption ?? $gallery->title) }}')">
                            <div style="height: 180px; overflow: hidden; background: #D6D2C0;">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $photo->caption ?? 'Foto kegiatan' }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s ease;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 24px; color: #7B8599;">
                                        📷
                                    </div>
                                @endif
                            </div>
                            @if($photo->caption)
                                <figcaption style="padding: 10px 12px; font-size: 13px; color: #4A5568; line-height: 1.4; border-top: 1px solid var(--color-line);">
                                    {{ $photo->caption }}
                                </figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            @else
                <p style="color: #5C6A79; font-style: italic;">Tidak ada berkas foto dalam album ini.</p>
            @endif
        </div>

        <!-- Galeri Video YouTube -->
        @if($gallery->videos->count() > 0)
            <div style="margin-bottom: 48px;">
                <div style="margin-bottom: 20px; border-bottom: 1px solid var(--color-line); padding-bottom: 8px;">
                    <h2 style="font-family: var(--font-display); font-size: 22px; margin: 0; color: var(--color-ink);">
                        Rekaman Video Kegiatan ({{ $gallery->videos->count() }})
                    </h2>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
                    @foreach($gallery->videos as $video)
                        @php
                            // Extract youtube ID
                            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $video->youtube_url, $matches);
                            $youtubeId = $matches[1] ?? null;
                        @endphp
                        <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); border-radius: 2px; overflow: hidden; padding: 12px;">
                            @if($youtubeId)
                                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 2px;">
                                    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" 
                                            title="{{ $video->caption ?? 'Video Kegiatan' }}" 
                                            style="position: absolute; top:0; left: 0; width: 100%; height: 100%; border:0;" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                    </iframe>
                                </div>
                            @else
                                <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer" style="display: block; padding: 20px; text-align: center; background: #ECE8D4; color: var(--color-ink); font-weight: 600;">
                                    Tonton di YouTube ↗
                                </a>
                            @endif
                            @if($video->caption)
                                <p style="margin: 10px 0 0 0; font-size: 14px; font-weight: 600; color: var(--color-ink);">
                                    {{ $video->caption }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Kembali ke Galeri -->
        <div style="padding-top: 24px; border-top: 1px solid var(--color-line);">
            <a href="{{ route('gallery.index') }}" class="btn btn-outline" style="font-size: 14px;">
                ← Kembali ke Daftar Album Galeri
            </a>
        </div>
    </div>
</article>

<!-- Lightbox Modal Component -->
<div id="lightbox" class="lightbox-modal" onclick="closeLightbox(event)">
    <div class="lightbox-content" onclick="event.stopPropagation()">
        <button type="button" class="lightbox-close" onclick="closeLightbox()">&times;</button>
        <img id="lightbox-image" class="lightbox-img" src="" alt="">
        <div id="lightbox-caption" class="lightbox-caption"></div>
    </div>
</div>

@push('scripts')
<script>
    function openLightbox(src, caption) {
        if (!src) return;
        document.getElementById('lightbox-image').src = src;
        document.getElementById('lightbox-caption').textContent = caption || '';
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.remove('active');
        document.body.style.overflow = '';
    }

    // Keyboard escape key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush

@endsection
