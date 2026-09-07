@props(['news'])

@php
    $coverUrl = $news->getFirstMediaUrl('cover', 'thumb') 
                ?: ($news->cover_path ? (str_starts_with($news->cover_path, 'http') ? $news->cover_path : asset('storage/' . $news->cover_path)) : null);
    $categoryName = $news->category?->name ?? 'Berita Sekolah';
    $publishDate = $news->published_at ? $news->published_at->translatedFormat('d F Y') : $news->created_at->translatedFormat('d F Y');
@endphp

<article class="news-card">
    <a href="{{ url('/berita/' . $news->slug) }}" class="news-thumb">
        @if($coverUrl)
            <img src="{{ $coverUrl }}" alt="{{ $news->title }}" loading="lazy">
        @else
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #E8EEF1; color: #50667D; font-family: var(--font-mono); font-size: 13px;">
                <span>SMPN 14 Surabaya</span>
            </div>
        @endif
    </a>

    <div class="news-meta">
        {{ $categoryName }} · {{ $publishDate }}
    </div>

    <h3>
        <a href="{{ url('/berita/' . $news->slug) }}">
            {{ $news->title }}
        </a>
    </h3>

    <p>
        {{ Str::limit($news->excerpt ?: strip_tags($news->content), 120) }}
    </p>
</article>
