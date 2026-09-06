@extends('layouts.app')

@section('title', 'Direktori Guru & Staf — SMP Negeri 14 Surabaya')
@section('meta_description', 'Daftar pendidik profesional dan tenaga kependidikan berdedikasi di SMP Negeri 14 Surabaya.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Guru & Staf']
    ]
])

<section class="section">
    <div class="container">
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 24px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
            <div>
                <span class="badge-mono badge-neutral" style="margin-bottom: 8px;">Pendidik & Tenaga Kependidikan</span>
                <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                    Dewan Guru & Staf Sekolah
                </h1>
                <p class="lead" style="margin-top: 8px; margin-bottom: 0;">
                    Profil para pendidik bersertifikasi dan tenaga administrasi yang membimbing serta melayani putra-putri SMPN 14 Surabaya.
                </p>
            </div>

            <!-- Search Form -->
            <form action="{{ route('teachers.index') }}" method="GET" style="display: flex; gap: 8px; min-width: 280px;">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama/mata pelajaran..." class="form-input" style="padding: 8px 12px; font-size: 14px;">
                <button type="submit" class="btn" style="padding: 8px 16px; font-size: 14px; white-space: nowrap;">Cari</button>
            </form>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="{{ route('teachers.index', request('q') ? ['q' => request('q')] : []) }}" 
               class="filter-tab {{ empty($filter) ? 'active' : '' }}">
                Semua Tenaga Pendidik & Staf
            </a>
            <a href="{{ route('teachers.index', array_merge(['kategori' => 'struktural'], request('q') ? ['q' => request('q')] : [])) }}" 
               class="filter-tab {{ $filter === 'struktural' ? 'active' : '' }}">
                Pimpinan Struktural
            </a>
            <a href="{{ route('teachers.index', array_merge(['kategori' => 'guru'], request('q') ? ['q' => request('q')] : [])) }}" 
               class="filter-tab {{ $filter === 'guru' ? 'active' : '' }}">
                Dewan Guru Mapel
            </a>
            <a href="{{ route('teachers.index', array_merge(['kategori' => 'staf'], request('q') ? ['q' => request('q')] : [])) }}" 
               class="filter-tab {{ $filter === 'staf' ? 'active' : '' }}">
                Tata Usaha & Karyawan
            </a>
        </div>

        <!-- Teachers Grid -->
        @if($teachers->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px;">
                @foreach($teachers as $teacher)
                    @php
                        $photoUrl = $teacher->getFirstMediaUrl('photo', 'thumb')
                                    ?: ($teacher->photo_path ? (str_starts_with($teacher->photo_path, 'http') ? $teacher->photo_path : asset('storage/' . $teacher->photo_path)) : null);
                    @endphp
                    <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); border-radius: 2px; display: flex; flex-direction: column; overflow: hidden;">
                        <!-- Pasfoto Rasio Buku Induk -->
                        <div style="height: 240px; background: #D6D2C0; border-bottom: 1px solid var(--color-line); overflow: hidden; position: relative;">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" alt="{{ $teacher->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 40px; color: #7B8599;">
                                    👤
                                </div>
                            @endif
                            @if($teacher->is_structural)
                                <span class="badge-mono badge-red" style="position: absolute; top: 10px; right: 10px; font-size: 11px;">
                                    Struktural
                                </span>
                            @endif
                        </div>

                        <!-- Data Guru -->
                        <div style="padding: 16px; flex: 1; display: flex; flex-direction: column;">
                            <h3 style="font-size: 16px; font-weight: 700; margin: 0 0 6px 0; color: var(--color-ink); line-height: 1.3;">
                                {{ $teacher->name }}
                            </h3>
                            <div style="font-family: var(--font-mono); font-size: 12px; color: #5C6A79; margin-bottom: 8px;">
                                {{ $teacher->nip ? 'NIP. ' . $teacher->nip : 'Tenaga Pendidik' }}
                            </div>
                            
                            <div style="margin-top: auto; padding-top: 10px; border-top: 1px dashed var(--color-line);">
                                <div style="font-size: 13px; font-weight: 600; color: var(--color-ink);">
                                    {{ $teacher->position }}
                                </div>
                                @if($teacher->subject)
                                    <div style="font-size: 13px; color: #626D7F; margin-top: 2px;">
                                        {{ $teacher->subject }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="background: var(--color-paper-alt); border: 1px dashed var(--color-line); padding: 48px; text-align: center; border-radius: 2px;">
                <p style="font-size: 18px; color: #5C6A79; margin: 0 0 12px 0;">Tidak ditemukan data guru atau staf yang sesuai.</p>
                <a href="{{ route('teachers.index') }}" class="btn btn-outline" style="font-size: 14px;">Tampilkan Semua Guru & Staf</a>
            </div>
        @endif
    </div>
</section>

@endsection
