@extends('layouts.app')

@section('title', 'Hubungi Kami & Layanan Informasi — SMP Negeri 14 Surabaya')
@section('meta_description', 'Kontak resmi SMP Negeri 14 Surabaya, alamat lokasi sekolah, nomor telepon layanan kedinasan, dan formulir pengiriman pesan pengaduan atau konsultasi.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Hubungi Kami']
    ]
])

<section class="section">
    <div class="container">
        
        <!-- Header -->
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 24px; margin-bottom: 36px;">
            <span class="badge-mono badge-neutral" style="margin-bottom: 8px;">Layanan Informasi & Konsultasi</span>
            <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                Hubungi SMP Negeri 14 Surabaya
            </h1>
            <p class="lead" style="margin-top: 8px; margin-bottom: 0;">
                Sampaikan pertanyaan, masukan, permohonan informasi kedinasan, atau konsultasi SPMB kepada tim tata usaha dan manajemen sekolah kami.
            </p>
        </div>

        <!-- Flash Message Sukses -->
        @if(session('success'))
            <div class="flash-success">
                <span style="font-size: 20px;">✓</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 40px; align-items: flex-start;">
            
            <!-- Kolom Kiri: Form Kirim Pesan -->
            <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 32px; border-radius: 2px;">
                <h2 style="font-family: var(--font-display); font-size: 24px; margin: 0 0 20px 0; color: var(--color-ink); border-bottom: 1px solid var(--color-line); padding-bottom: 12px;">
                    Formulir Kirim Pesan
                </h2>

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Masukkan nama Anda">
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="email" class="form-label">Alamat Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="nama@email.com">
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Nomor Telepon / WA</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">Perihal / Subjek Pesan *</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required class="form-input" placeholder="Misal: Konsultasi SPMB / Permohonan Informasi">
                        @error('subject')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Isi Pesan *</label>
                        <textarea id="message" name="message" rows="5" required class="form-textarea" placeholder="Tuliskan pesan, saran, atau pertanyaan Anda secara rinci di sini...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn" style="width: 100%; padding: 12px; font-size: 15px; font-weight: 600;">
                        Kirim Pesan ke Pihak Sekolah
                    </button>
                </form>
            </div>

            <!-- Kolom Kanan: Informasi Kontak & Jam Layanan -->
            <div>
                <!-- Kartu Kontak Sekolah -->
                <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 28px; border-radius: 2px; margin-bottom: 24px;">
                    <h2 style="font-family: var(--font-display); font-size: 20px; margin: 0 0 16px 0; color: var(--color-ink); border-bottom: 1px solid var(--color-line); padding-bottom: 8px;">
                        Kantor & Layanan Dinas
                    </h2>

                    <div style="display: flex; flex-direction: column; gap: 16px; font-size: 15px;">
                        <div>
                            <strong style="color: var(--color-ink); display: block; font-size: 13px; font-family: var(--font-mono); text-transform: uppercase; margin-bottom: 4px;">Alamat Kampus:</strong>
                            <p style="margin: 0; color: #3C4A63; line-height: 1.5;">
                                {{ $settings['address'] ?? 'Jl. Jurang Kuping, Kel. Benowo, Kec. Pakal, Kota Surabaya, Jawa Timur 60195' }}
                            </p>
                        </div>

                        <div>
                            <strong style="color: var(--color-ink); display: block; font-size: 13px; font-family: var(--font-mono); text-transform: uppercase; margin-bottom: 4px;">Telepon Kantor:</strong>
                            <span style="font-family: var(--font-mono); color: #3C4A63;">
                                {{ $settings['phone'] ?? '(031) 7405230' }}
                            </span>
                        </div>

                        <div>
                            <strong style="color: var(--color-ink); display: block; font-size: 13px; font-family: var(--font-mono); text-transform: uppercase; margin-bottom: 4px;">Surat Elektronik:</strong>
                            <a href="mailto:{{ $settings['email'] ?? 'info@smpn14surabaya.sch.id' }}" style="font-family: var(--font-mono); color: var(--color-red); text-decoration: underline;">
                                {{ $settings['email'] ?? 'info@smpn14surabaya.sch.id' }}
                            </a>
                        </div>

                        <div style="border-top: 1px dashed var(--color-line); padding-top: 14px;">
                            <strong style="color: var(--color-ink); display: block; font-size: 13px; font-family: var(--font-mono); text-transform: uppercase; margin-bottom: 6px;">Jam Pelayanan Tata Usaha:</strong>
                            <div style="font-family: var(--font-mono); font-size: 13px; color: #4A5568; line-height: 1.6;">
                                Senin – Kamis: 07.00 – 15.00 WIB<br>
                                Jumat: 07.00 – 14.30 WIB<br>
                                Sabtu, Minggu & Hari Libur Nasional: Tutup
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peta Lokasi (Embed) -->
                <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 12px; border-radius: 2px;">
                    <div style="height: 240px; background: #E5E1CD; border: 1px solid var(--color-line); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 20px;">
                        <span style="font-size: 32px; margin-bottom: 8px;">📍</span>
                        <strong style="font-size: 15px; color: var(--color-ink);">SMP Negeri 14 Surabaya</strong>
                        <span style="font-size: 13px; color: #5C6A79; margin-top: 4px;">Kecamatan Pakal, Kota Surabaya</span>
                        <a href="https://maps.google.com/?q=SMP+Negeri+14+Surabaya" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="margin-top: 14px; font-size: 13px; padding: 6px 14px;">
                            Buka di Google Maps ↗
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

@endsection
