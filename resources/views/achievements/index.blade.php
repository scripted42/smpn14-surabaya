@extends('layouts.app')

@section('title', 'Katalog Prestasi & Kejuaraan — SMP Negeri 14 Surabaya')
@section('meta_description', 'Daftar raihan medali, trofi kejuaraan sains, seni budaya, olahraga, dan kepramukaan siswa-siswi SMP Negeri 14 Surabaya.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Prestasi Siswa']
    ]
])

<section class="section">
    <div class="container">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 24px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
            <div>
                <span class="badge-mono badge-gold" style="margin-bottom: 8px;">Kebanggaan Warga 14</span>
                <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                    Prestasi & Kejuaraan Pelajar
                </h1>
                <p class="lead" style="margin-top: 8px; margin-bottom: 0;">
                    Rekam jejak perjuangan peserta didik dan tim sekolah dalam menorehkan prestasi gemilang dari tingkat kota hingga nasional.
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('achievements.index') }}" method="GET" style="display: flex; gap: 8px; min-width: 280px;">
                @if(request('tingkat'))
                    <input type="hidden" name="tingkat" value="{{ request('tingkat') }}">
                @endif
                @if(request('tahun'))
                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                @endif
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama siswa/lomba..." class="form-input" style="padding: 8px 12px; font-size: 14px;">
                <button type="submit" class="btn" style="padding: 8px 16px; font-size: 14px; white-space: nowrap;">Cari</button>
            </form>
        </div>

        <!-- Filter Bar: Tingkat & Tahun -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
            <!-- Filter Tingkat -->
            <div class="filter-tabs" style="margin-bottom: 0;">
                <a href="{{ route('achievements.index', array_filter(['tahun' => $year, 'q' => $search])) }}" 
                   class="filter-tab {{ empty($level) ? 'active' : '' }}">
                    Semua Tingkat
                </a>
                @foreach(['kota' => 'Tingkat Kota', 'provinsi' => 'Jawa Timur', 'nasional' => 'Nasional', 'internasional' => 'Internasional'] as $lvlKey => $lvlLabel)
                    <a href="{{ route('achievements.index', array_filter(['tingkat' => $lvlKey, 'tahun' => $year, 'q' => $search])) }}" 
                       class="filter-tab {{ $level === $lvlKey ? 'active' : '' }}">
                        {{ $lvlLabel }}
                    </a>
                @endforeach
            </div>

            <!-- Filter Tahun (Dropdown) -->
            <form action="{{ route('achievements.index') }}" method="GET" style="display: flex; align-items: center; gap: 8px;">
                @if(request('tingkat'))
                    <input type="hidden" name="tingkat" value="{{ request('tingkat') }}">
                @endif
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                <label for="filter-tahun" style="font-family: var(--font-mono); font-size: 13px; color: #5C6A79;">Tahun:</label>
                <select id="filter-tahun" name="tahun" onchange="this.form.submit()" class="form-select" style="padding: 6px 12px; font-size: 13px; font-family: var(--font-mono); width: auto;">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ (string)$year === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Prestasi Grid -->
        @if($achievements->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                @foreach($achievements as $item)
                    @php
                        $photoUrl = $item->getFirstMediaUrl('photo', 'thumb') 
                                    ?: ($item->photo_path ? (str_starts_with($item->photo_path, 'http') ? $item->photo_path : asset('storage/' . $item->photo_path)) : null);
                        $badgeClass = match($item->level) {
                            'internasional' => 'badge-red',
                            'nasional' => 'badge-gold',
                            'provinsi' => 'badge-green',
                            default => 'badge-neutral',
                        };
                    @endphp
                    <article style="background: var(--color-paper-alt); border: 1px solid var(--color-line); border-radius: 2px; padding: 20px; display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <span class="badge-mono {{ $badgeClass }}">
                                Tingkat {{ ucfirst($item->level) }}
                            </span>
                            <span style="font-family: var(--font-mono); font-size: 13px; font-weight: 700; color: var(--color-ink);">
                                {{ $item->year }}
                            </span>
                        </div>

                        @if($photoUrl)
                            <div style="height: 180px; overflow: hidden; background: #D6D2C0; margin-bottom: 14px; border: 1px solid var(--color-line); border-radius: 2px;">
                                <img src="{{ $photoUrl }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endif

                        <h3 style="font-size: 17px; font-weight: 700; margin: 0 0 8px 0; color: var(--color-ink); line-height: 1.35;">
                            {{ $item->title }}
                        </h3>

                        @if($item->student_name)
                            <div style="font-size: 14px; color: var(--color-red); font-weight: 600; margin-bottom: 8px;">
                                Peraih: {{ $item->student_name }}
                            </div>
                        @endif

                        @if($item->description)
                            <p style="font-size: 14px; color: #4A5568; line-height: 1.5; margin: 0 0 12px 0;">
                                {{ $item->description }}
                            </p>
                        @endif

                        @if($item->category)
                            <div style="margin-top: auto; padding-top: 10px; border-top: 1px dashed var(--color-line); font-family: var(--font-mono); font-size: 12px; color: #5C6A79;">
                                Bidang: {{ $item->category->name }}
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            {{ $achievements->links('partials.pagination') }}
        @else
            <div style="background: var(--color-paper-alt); border: 1px dashed var(--color-line); padding: 48px; text-align: center; border-radius: 2px;">
                <p style="font-size: 18px; color: #5C6A79; margin: 0 0 12px 0;">Tidak ada catatan prestasi yang sesuai dengan kriteria filter.</p>
                <a href="{{ route('achievements.index') }}" class="btn btn-outline" style="font-size: 14px;">Reset Filter Prestasi</a>
            </div>
        @endif
    </div>
</section>

@endsection
