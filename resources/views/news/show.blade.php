@extends('layouts.app')

@section('title', ($news->meta_title ?: $news->title) . ' — SMP Negeri 14 Surabaya')
@section('meta_description', $news->meta_description ?: Str::limit(strip_tags($news->excerpt ?: $news->content), 150))

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Berita', 'url' => route('news.index')],
        ['label' => $news->category?->name ?? 'Berita', 'url' => $news->category ? route('news.index', ['kategori' => $news->category->slug]) : null],
        ['label' => Str::limit($news->title, 40)]
    ]
])

@php
    $coverUrl = $news->getFirstMediaUrl('cover') 
                ?: ($news->cover_path ? (str_starts_with($news->cover_path, 'http') ? $news->cover_path : asset('storage/' . $news->cover_path)) : null);
    $categoryName = $news->category?->name ?? 'Berita Sekolah';
    $publishDate = $news->published_at ? $news->published_at->translatedFormat('d F Y, H:i') . ' WIB' : $news->created_at->translatedFormat('d F Y');
@endphp

<article class="section" style="padding-top: 40px;">
    <div class="container" style="max-width: 920px;">
        
        <!-- Header Artikel -->
        <header style="margin-bottom: 32px; border-bottom: 1px solid var(--color-line); padding-bottom: 24px;">
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 12px; flex-wrap: wrap;">
                @if($news->category)
                    <a href="{{ route('news.index', ['kategori' => $news->category->slug]) }}" class="badge-mono badge-red">
                        {{ $categoryName }}
                    </a>
                @endif
                <time class="news-meta" style="margin: 0; font-family: var(--font-mono); font-size: 13px;">
                    {{ $publishDate }}
                </time>
                <span style="color: var(--color-line);">·</span>
                <span style="font-family: var(--font-mono); font-size: 13px; color: #5C6A79;">
                    Dibaca {{ number_format($news->views_count) }} kali
                </span>
            </div>

            <h1 style="font-family: var(--font-display); font-size: 36px; line-height: 1.25; margin: 0 0 16px 0; color: var(--color-ink);">
                {{ $news->title }}
            </h1>

            @if($news->excerpt)
                <p class="lead" style="font-size: 19px; color: #3C4A63; line-height: 1.6; margin: 0;">
                    {{ $news->excerpt }}
                </p>
            @endif
        </header>

        <!-- Cover Image -->
        @if($coverUrl)
            <figure style="margin: 0 0 36px 0; border: 1px solid var(--color-line); background: var(--color-paper-alt); padding: 6px;">
                <img src="{{ $coverUrl }}" alt="{{ $news->title }}" style="width: 100%; max-height: 520px; object-fit: cover; border-radius: 2px;">
                <figcaption style="font-family: var(--font-mono); font-size: 12px; color: #5C6A79; padding: 8px 6px 4px 6px;">
                    Dokumentasi Resmi SMP Negeri 14 Surabaya
                </figcaption>
            </figure>
        @endif

        <!-- Body Content -->
        <div class="article-content" style="font-size: 17px; line-height: 1.8; color: var(--color-ink); max-width: 100%;">
            {!! $news->content !!}
        </div>

        <!-- Tags -->
        @if($news->tags->count() > 0)
            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--color-line); display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="font-family: var(--font-mono); font-size: 13px; font-weight: 600; color: #5C6A79;">Topik Terkait:</span>
                @foreach($news->tags as $t)
                    <span class="badge-mono badge-neutral" style="font-size: 12px; font-weight: 500;">
                        #{{ $t->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Tombol Bagikan / Kembali -->
        <div style="margin-top: 32px; padding: 16px 20px; background: var(--color-paper-alt); border: 1px solid var(--color-line); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <a href="{{ route('news.index') }}" class="btn btn-outline" style="font-size: 14px;">
                ← Kembali ke Daftar Berita
            </a>
            <div style="font-family: var(--font-mono); font-size: 13px; color: #5C6A79;">
                Bagikan: 
                <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" style="color: var(--color-ink); text-decoration: underline; margin-left: 8px;">WhatsApp</a>
            </div>
        </div>
    </div>
</article>

<!-- 3 Berita Terkait -->
@if($relatedNews->count() > 0)
<section class="section section-alt">
    <div class="container" style="max-width: 920px;">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 12px; margin-bottom: 28px;">
            <h2 style="font-family: var(--font-display); font-size: 24px; margin: 0;">Berita Terkait Lainnya</h2>
        </div>

        <div class="news-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
            @foreach($relatedNews as $related)
                @include('partials.news-card', ['news' => $related])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
