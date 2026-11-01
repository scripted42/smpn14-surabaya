@extends('layouts.app')

@section('title', 'Layanan Aspirasi, Kritik & Aduan — SMP Negeri 14 Surabaya')
@section('meta_description', 'Kanal resmi aspirasi, pengaduan, kritik, dan saran SMP Negeri 14 Surabaya. Sampaikan aspirasi secara aman, rahasia, dan transparan demi kemajuan bersama.')

@section('content')

@include('partials.breadcrumb', [
    'items' => [
        ['label' => 'Aduan & Aspirasi']
    ]
])

<section class="section">
    <div class="container">
        
        <!-- Header Page -->
        <div style="border-bottom: 2px solid var(--color-ink); padding-bottom: 24px; margin-bottom: 36px;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px;">
                <div>
                    <span class="badge-mono badge-neutral" style="margin-bottom: 8px;">Keterbukaan &amp; Akuntabilitas Sekolah</span>
                    <h1 class="eyebrow-free-heading" style="margin-top: 6px;">
                        Layanan Aspirasi, Kritik &amp; Pengaduan
                    </h1>
                    <p class="lead" style="margin-top: 8px; margin-bottom: 0; max-width: 75ch;">
                        SMP Negeri 14 Surabaya berkomitmen mewujudkan lingkungan pendidikan yang aman, nyaman, transparan, dan berkarakter. Kami membuka pintu selebar-lebarnya bagi siswa, orang tua, alumni, maupun masyarakat umum untuk menyampaikan aspirasi dan masukan membangun.
                    </p>
                </div>
                <div>
                    <a href="#lacak" class="btn btn-secondary" style="font-size: 13px; font-family: var(--font-mono);">
                        🔍 Lacak Status Tiket
                    </a>
                </div>
            </div>

            <!-- 3 Pilar Keamanan & Pelayanan -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; margin-top: 28px;">
                <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 16px 20px; border-left: 3px solid var(--color-teal); border-radius: 2px;">
                    <div style="font-weight: 700; font-size: 14px; color: var(--color-ink); margin-bottom: 4px;">🔒 Kerahasiaan &amp; Opsi Anonim</div>
                    <div style="font-size: 13px; color: #50667D;">Anda berhak memilih pengiriman secara anonim demi perlindungan privasi dan keamanan Anda.</div>
                </div>
                <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 16px 20px; border-left: 3px solid var(--color-gold); border-radius: 2px;">
                    <div style="font-weight: 700; font-size: 14px; color: var(--color-ink); margin-bottom: 4px;">📋 Nomor Registrasi Tiket</div>
                    <div style="font-size: 13px; color: #50667D;">Setiap laporan memperoleh kode tiket unik yang dapat dipantau perkembangannya kapan saja.</div>
                </div>
                <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 16px 20px; border-left: 3px solid var(--color-navy); border-radius: 2px;">
                    <div style="font-weight: 700; font-size: 14px; color: var(--color-ink); margin-bottom: 4px;">⚡ Ditindaklanjuti Resmi</div>
                    <div style="font-size: 13px; color: #50667D;">Laporan diverifikasi langsung oleh pimpinan dan unit terkait untuk dicarikan solusi konkret.</div>
                </div>
            </div>
        </div>

        <!-- Flash Sukses Kirim Aduan -->
        @if(session('complaint_success'))
            <div style="background: #EBF8F2; border: 1px solid #75C695; padding: 24px; border-radius: 4px; margin-bottom: 32px; display: flex; gap: 18px; align-items: flex-start;">
                <div style="background: #2E8540; color: #fff; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; flex-shrink: 0;">✓</div>
                <div>
                    <h3 style="font-size: 18px; font-weight: 700; color: #1C5428; margin: 0 0 6px 0;">Aspirasi Berhasil Dikirimkan!</h3>
                    <p style="margin: 0 0 12px 0; color: #234E2E; font-size: 14px; line-height: 1.5;">
                        Terima kasih telah berkontribusi memberikan masukan untuk SMP Negeri 14 Surabaya. Simpan nomor tiket di bawah ini untuk mengecek progres tindak lanjut:
                    </p>
                    <div style="display: inline-flex; align-items: center; gap: 10px; background: #FFFFFF; border: 1px dashed #2E8540; padding: 8px 16px; border-radius: 4px;">
                        <span style="font-size: 12px; font-family: var(--font-mono); color: #555;">KODE TIKET:</span>
                        <strong style="font-family: var(--font-mono); font-size: 18px; color: var(--color-ink); letter-spacing: 1px;">{{ session('ticket_number') }}</strong>
                    </div>
                </div>
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1.25fr 0.75fr; gap: 40px; align-items: flex-start;">
            
            <!-- Kolom Kiri: Formulir Pengaduan / Aspirasi -->
            <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 36px; border-radius: 2px;">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-line); padding-bottom: 14px; margin-bottom: 24px;">
                    <h2 style="font-family: var(--font-display); font-size: 22px; margin: 0; color: var(--color-ink);">
                        Formulir Aspirasi &amp; Aduan
                    </h2>
                    <span style="font-size: 12px; font-family: var(--font-mono); color: #64748B;">* Wajib diisi</span>
                </div>

                <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Opsi Identitas Anonim -->
                    <div style="background: #F8FAFC; border: 1px solid #E2E8F0; padding: 14px 18px; border-radius: 4px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <label for="is_anonymous" style="font-weight: 600; font-size: 14px; color: var(--color-ink); cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }} onchange="toggleAnonymous(this.checked)" style="width: 17px; height: 17px; accent-color: var(--color-teal); cursor: pointer;">
                                Rahasiakan Identitas Saya (Kirim sebagai Anonim)
                            </label>
                            <div style="font-size: 12px; color: #64748B; margin-left: 25px; margin-top: 2px;">
                                Nama Anda tidak akan ditampilkan pada laporan jika opsi ini dicentang.
                            </div>
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group" id="name-container">
                        <label for="name" class="form-label">Nama Lengkap <span id="name-required" style="color: #9B3226;">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kategori Pelapor & Kategori Masukan -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="role" class="form-label">Identitas Pelapor <span style="color: #9B3226;">*</span></label>
                            <select id="role" name="role" required class="form-input" style="cursor: pointer;">
                                <option value="">-- Pilih Identitas --</option>
                                @foreach(\App\Models\Complaint::ROLES as $key => $val)
                                    <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category" class="form-label">Kategori Masukan <span style="color: #9B3226;">*</span></label>
                            <select id="category" name="category" required class="form-input" style="cursor: pointer;">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(\App\Models\Complaint::CATEGORIES as $key => $val)
                                    <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kontak: Email & Telepon -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group">
                            <label for="email" class="form-label">Alamat Email <span style="font-size: 11px; font-weight: normal; color: #64748B;">(Opsional)</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="contoh@email.com">
                            @error('email')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">No. Telepon / WhatsApp <span style="font-size: 11px; font-weight: normal; color: #64748B;">(Opsional)</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="08xxxxxxxxxx">
                            @error('phone')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Judul / Perihal -->
                    <div class="form-group">
                        <label for="title" class="form-label">Perihal / Judul Aspirasi / Aduan <span style="color: #9B3226;">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required class="form-input" placeholder="Ringkasan inti masukan Anda (contoh: Usulan Penambahan Tempat Sampah Pilah)">
                        @error('title')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Uraian Lengkap -->
                    <div class="form-group">
                        <label for="content" class="form-label">Uraian Lengkap Aspirasi / Aduan <span style="color: #9B3226;">*</span></label>
                        <textarea id="content" name="content" rows="6" required class="form-input" placeholder="Jelaskan secara runtut fakta, saran, kejadian, lokasi, atau ide perbaikan yang ingin Anda sampaikan...">{{ old('content') }}</textarea>
                        <div style="font-size: 12px; color: #64748B; margin-top: 4px;">Minimal 10 karakter. Uraikan dengan santun dan objektif.</div>
                        @error('content')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Lampiran File / Foto -->
                    <div class="form-group">
                        <label for="attachment" class="form-label">Lampiran Bukti / Foto Pendukung <span style="font-size: 11px; font-weight: normal; color: #64748B;">(Opsional)</span></label>
                        <input type="file" id="attachment" name="attachment" class="form-input" accept=".jpg,.jpeg,.png,.webp,.pdf">
                        <div style="font-size: 12px; color: #64748B; margin-top: 4px;">Format berkas: JPG, PNG, WebP, PDF. Ukuran maks. 5MB.</div>
                        @error('attachment')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--color-line); display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 12px; color: #64748B; font-family: var(--font-mono);">
                            SMPN 14 Surabaya · Whistleblowing &amp; Public Aspiration
                        </span>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-size: 15px; font-weight: 600;">
                            Kirim Aspirasi Sekarang 📨
                        </button>
                    </div>
                </form>
            </div>

            <!-- Kolom Kanan: Pelacakan Tiket & Informasi Layanan -->
            <div>

                <!-- Card 1: Lacak Status Tiket -->
                <div id="lacak" style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 28px; border-radius: 2px; margin-bottom: 24px; scroll-margin-top: 100px;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                        <span style="font-size: 20px;">🔍</span>
                        <h3 style="font-family: var(--font-display); font-size: 20px; margin: 0; color: var(--color-ink);">
                            Lacak Status Aduan
                        </h3>
                    </div>
                    <p style="font-size: 13px; color: #50667D; margin-bottom: 18px; line-height: 1.5;">
                        Masukkan nomor tiket yang Anda dapatkan saat mengirimkan laporan untuk melihat progres dan tanggapan resmi dari pihak sekolah.
                    </p>

                    <form action="{{ route('complaint.track') }}" method="POST">
                        @csrf
                        <div style="display: flex; gap: 8px;">
                            <input type="text" name="ticket_number" value="{{ old('ticket_number') }}" required placeholder="Contoh: ASP-2611-ABCD" class="form-input" style="font-family: var(--font-mono); text-transform: uppercase;">
                            <button type="submit" class="btn btn-primary" style="white-space: nowrap; padding: 0 16px;">
                                Lacak
                            </button>
                        </div>
                        @error('ticket_number')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </form>

                    <!-- Pesan Error Lacak -->
                    @if(session('track_error'))
                        <div style="background: #FDF2F2; border: 1px solid #F8B4B4; color: #9B3226; padding: 12px 14px; border-radius: 4px; font-size: 13px; margin-top: 14px;">
                            {{ session('track_error') }}
                        </div>
                    @endif

                    <!-- Hasil Lacak Tiket -->
                    @if(session('track_result'))
                        @php $result = session('track_result'); @endphp
                        <div style="margin-top: 20px; background: #F8FAFC; border: 1px solid #CBD5E1; padding: 18px; border-radius: 4px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #E2E8F0; padding-bottom: 8px;">
                                <span style="font-family: var(--font-mono); font-size: 14px; font-weight: 700; color: var(--color-ink);">
                                    {{ $result->ticket_number }}
                                </span>
                                @php
                                    $badgeStyle = match($result->status) {
                                        'pending' => 'background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D;',
                                        'diproses' => 'background: #DBEAFE; color: #1E40AF; border: 1px solid #93C5FD;',
                                        'selesai' => 'background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7;',
                                        'ditolak' => 'background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5;',
                                        default => 'background: #F3F4F6; color: #374151;',
                                    };
                                @endphp
                                <span style="font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 2px; {{ $badgeStyle }}">
                                    {{ $result->status_label }}
                                </span>
                            </div>

                            <div style="font-size: 13px; color: var(--color-ink); margin-bottom: 6px;">
                                <strong>Perihal:</strong> {{ $result->title }}
                            </div>
                            <div style="font-size: 12px; color: #64748B; margin-bottom: 6px;">
                                <strong>Kategori:</strong> {{ $result->category_label }} · <strong>Pelapor:</strong> {{ $result->is_anonymous ? 'Anonim' : $result->name }}
                            </div>
                            <div style="font-size: 12px; color: #64748B; margin-bottom: 12px; font-family: var(--font-mono);">
                                Diajukan: {{ $result->created_at->format('d M Y, H:i') }} WIB
                            </div>

                            <div style="background: #FFFFFF; border: 1px solid #E2E8F0; padding: 12px; border-radius: 4px; margin-top: 10px;">
                                <div style="font-size: 12px; font-weight: 700; color: var(--color-ink); margin-bottom: 4px;">
                                    💬 Tanggapan Resmi Sekolah:
                                </div>
                                @if($result->response)
                                    <div style="font-size: 13px; color: #1E293B; line-height: 1.5; white-space: pre-line;">
                                        {{ $result->response }}
                                    </div>
                                    @if($result->responded_at)
                                        <div style="font-size: 11px; color: #64748B; margin-top: 6px; font-family: var(--font-mono);">
                                            Waktu tanggapan: {{ $result->responded_at->format('d M Y, H:i') }} WIB
                                        </div>
                                    @endif
                                @else
                                    <div style="font-size: 13px; color: #64748B; font-style: italic;">
                                        Laporan Anda telah berhasil masuk ke sistem dan sedang dalam antrean verifikasi oleh tim kesiswaan / tata usaha SMPN 14 Surabaya.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card 2: Alur Penanganan Aduan -->
                <div style="background: var(--color-paper-alt); border: 1px solid var(--color-line); padding: 28px; border-radius: 2px; margin-bottom: 24px;">
                    <h3 style="font-family: var(--font-display); font-size: 18px; margin: 0 0 16px 0; color: var(--color-ink);">
                        Alur Penanganan Masukan
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--color-teal); color: #fff; font-family: var(--font-mono); font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">1</div>
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: var(--color-ink);">Pengajuan Laporan</div>
                                <div style="font-size: 12px; color: #50667D;">Pengirim mengisi formulir dan memperoleh nomor registrasi tiket unik.</div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--color-teal); color: #fff; font-family: var(--font-mono); font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">2</div>
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: var(--color-ink);">Verifikasi &amp; Telaah Dokumen</div>
                                <div style="font-size: 12px; color: #50667D;">Tim penanganan memeriksa relevansi dan bukti pendukung aduan secara objektif.</div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--color-teal); color: #fff; font-family: var(--font-mono); font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">3</div>
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: var(--color-ink);">Tindak Lanjut Koordinasi</div>
                                <div style="font-size: 12px; color: #50667D;">Sekolah melakukan perbaikan sarana, klarifikasi, atau evaluasi KBM sesuai kewenangan.</div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 12px; align-items: flex-start;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--color-teal); color: #fff; font-family: var(--font-mono); font-size: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">4</div>
                            <div>
                                <div style="font-size: 13px; font-weight: 700; color: var(--color-ink);">Tanggapan Resmi</div>
                                <div style="font-size: 12px; color: #50667D;">Hasil penyelesaian dicatat dan dapat dilihat oleh pelapor melalui fitur pelacakan tiket.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Layanan Kontak Langsung -->
                <div style="background: #F1F5F9; border: 1px solid var(--color-line); padding: 22px; border-radius: 2px;">
                    <div style="font-weight: 700; font-size: 14px; color: var(--color-ink); margin-bottom: 6px;">
                        Butuh Klarifikasi Cepat?
                    </div>
                    <p style="font-size: 13px; color: #50667D; margin-bottom: 12px; line-height: 1.4;">
                        Untuk urusan kedinasan mendesak, silakan hubungi Ruang Tata Usaha atau nomor layanan resmi:
                    </p>
                    <div style="font-family: var(--font-mono); font-size: 13px; color: var(--color-ink); margin-bottom: 4px;">
                        📞 {{ $settings['phone'] ?? '(031) 7405230' }}
                    </div>
                    <div style="font-family: var(--font-mono); font-size: 13px; color: var(--color-teal);">
                        ✉️ {{ $settings['email'] ?? 'info@smpn14surabaya.sch.id' }}
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

@push('scripts')
<script>
function toggleAnonymous(isAnon) {
    const nameContainer = document.getElementById('name-container');
    const nameInput = document.getElementById('name');
    const nameReq = document.getElementById('name-required');
    
    if (isAnon) {
        if (nameReq) nameReq.style.display = 'none';
        nameInput.placeholder = 'Nama Anda (Opsional jika memilih anonim)';
        nameInput.removeAttribute('required');
    } else {
        if (nameReq) nameReq.style.display = 'inline';
        nameInput.placeholder = 'Masukkan nama lengkap Anda';
        nameInput.setAttribute('required', 'required');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const anonCheckbox = document.getElementById('is_anonymous');
    if (anonCheckbox) {
        toggleAnonymous(anonCheckbox.checked);
    }
});
</script>
@endpush

@endsection

