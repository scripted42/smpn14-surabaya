@extends('layouts.app')

@section('title', ($currentCategory ? $currentCategory->name . ' — ' : '') . 'Berita & Informasi — SMP Negeri 14 Surabaya')
@section('meta_description', 'Arsip berita resmi, agenda kesiswaan, prestasi siswa, dan publikasi kurikulum SMP Negeri 14 Surabaya.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Berita', 'url' => $currentCategory ? route('news.index') : null],
        ...($currentCategory ? [['label' => $currentCategory->name]] : [])
    ]
])

<section class="section">
    <div class="container">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 24px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
            <div>
                <span class="badge-mono badge-neutral" style="margin-bottom: 8px;">Arsip Berita Resmi</span>
                <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                    {{ $currentCategory ? $currentCategory->name : 'Kabar & Berita Terkini' }}
                </h1>
                <p class="lead" style="margin-top: 8px; margin-bottom: 0;">
                    Informasi terpercaya seputar kegiatan pembelajaran, kejuaraan, pengumuman kedinasan, dan kehidupan warga SMPN 14 Surabaya.
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('news.index') }}" method="GET" style="display: flex; gap: 8px; min-width: 280px;">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari judul berita..." class="form-input" style="padding: 8px 12px; font-size: 14px;">
                <button type="submit" class="btn" style="padding: 8px 16px; font-size: 14px; white-space: nowrap;">Cari</button>
            </form>
        </div>

        <!-- Filter Kategori Tabs -->
        <div class="filter-tabs">
            <a href="{{ route('news.index', request('q') ? ['q' => request('q')] : []) }}" 
               class="filter-tab {{ !$currentCategory ? 'active' : '' }}">
                Semua Kategori
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('news.index', array_merge(['kategori' => $cat->slug], request('q') ? ['q' => request('q')] : [])) }}" 
                   class="filter-tab {{ $currentCategory && $currentCategory->id === $cat->id ? 'active' : '' }}">
                    {{ $cat->name }} ({{ $cat->news_count }})
                </a>
            @endforeach
        </div>

        <!-- News Grid -->
        @if($news->count() > 0)
            <div class="news-grid">
                @foreach($news as $item)
                    @include('partials.news-card', ['news' => $item])
                @endforeach
            </div>

            <!-- Custom Pagination -->
            {{ $news->links('partials.pagination') }}
        @else
            <div style="background: var(--color-paper-alt); border: 1px dashed var(--color-line); padding: 48px; text-align: center; border-radius: 2px;">
                <p style="font-size: 18px; color: #5C6A79; margin: 0 0 12px 0;">Tidak ditemukan artikel berita yang sesuai kriteria pencarian.</p>
                <a href="{{ route('news.index') }}" class="btn btn-outline" style="font-size: 14px;">Kembali ke Semua Berita</a>
            </div>
        @endif
    </div>
</section>

@endsection
