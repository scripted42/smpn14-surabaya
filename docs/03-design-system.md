# Design System — "Jadwal & Rapor" Visual Language

Arah desain ini diambil dari artefak yang paling akrab di dunia sekolah Indonesia: **jadwal pelajaran** dan **kertas rapor/ujian**. Grid, garis pembatas tipis, dan nomor urut dipakai secara fungsional (bukan dekorasi generik), sehingga hasilnya terasa spesifik untuk sekolah — bukan template SaaS yang dipoles ulang.

## 1. Palet Warna

| Nama | Hex | Peran |
|---|---|---|
| Kertas Ujian | `#EDEAD9` | Background utama, hangat tapi tidak cream-default |
| Tinta | `#1F2A44` | Teks utama, header, elemen struktural (garis, border) |
| Merah Rapor | `#9B3226` | Aksen utama — CTA penting, badge "Baru", PPDB dibuka |
| Kuning Prestasi | `#C99A3E` | Aksen sekunder — prestasi, highlight statistik |
| Abu Garis | `#A79E8C` | Garis pembatas/divider, border halus |
| Hijau Papan | `#2F4A3C` | Aksen tersier — status positif, footer, elemen kontras |
| Putih Kertas | `#FBFAF5` | Card/section alternate background |

Kontras Tinta (#1F2A44) di atas Kertas Ujian (#EDEAD9) ≈ 10.8:1 — jauh di atas AA untuk teks body.

## 2. Tipografi

| Peran | Font | Alasan |
|---|---|---|
| Display/Headline | **IBM Plex Serif**, weight 600–700 | Karakter seperti buku pelajaran/cetakan resmi, bukan serif "editorial" yang jadi default AI (Fraunces/Playfair) |
| Body | **IBM Plex Sans**, weight 400–500 | Netral, sangat terbaca di layar kecil, satu keluarga dengan display font (konsistensi visual) |
| Angka/kode/jadwal | **IBM Plex Mono**, weight 500 | Dipakai khusus untuk jam, kode kelas, nomor telepon — meniru tipografi jadwal cetak |

**Type scale** (basis 16px, rasio ~1.25):

| Token | Size | Line-height | Pemakaian |
|---|---|---|---|
| display-xl | 48px / 3rem | 1.1 | Headline hero |
| display-l | 34px | 1.15 | Judul section |
| heading | 24px | 1.3 | Judul card/artikel |
| body-l | 18px | 1.6 | Lead paragraph |
| body | 16px | 1.6 | Teks umum |
| small | 14px | 1.5 | Meta info, caption |
| mono-label | 13px | 1.4 | Jadwal, kode, angka statistik kecil |

Line length body dibatasi **≤ 72 karakter** (`max-width: 62ch`).

**Hindari:** all-caps untuk label, bold/italic pada satu kata di headline, label "EYEBROW" di atas judul, tanda "→" di akhir tombol.

## 3. Spacing & Grid

- Unit dasar: `8px` (0.5rem), skala: 8/16/24/32/48/64/96
- Grid section: 12 kolom, gutter 24px, container max-width `1280px`
- Radius: **tidak seragam**. Foto/gambar: radius 4px (nyaris tegas, seperti foto tempel di rapor). Elemen interaktif (tombol, input): radius 2px. Tidak ada elemen dengan radius besar (>8px) — hindari kesan "SaaS card kit"
- Shadow: dihindari sebagai default. Pemisah antar elemen pakai **garis (border 1px solid Abu Garis)**, bukan drop-shadow generik. Shadow hanya dipakai pada elemen mengambang aktif (modal, dropdown)

## 4. Prinsip Struktural

1. **Grid jadwal sebagai motif berulang** — dipakai literal di section "Jadwal & Program" dan diam-diam sebagai struktur garis di section lain (garis horizontal tipis memisah tiap section, seperti baris tabel)
2. **Nomor hanya untuk urutan nyata** — dipakai di timeline PPDB (memang berurutan), TIDAK dipakai di grid fasilitas/berita (bukan urutan)
3. **Satu momen visual berani**: garis vertikal tebal Merah Rapor di sisi kiri hero sebagai "penanda halaman terbuka", elemen lain tetap tenang
4. **Rata kiri konsisten** — teks dan heading rata kiri, bukan center-align (memberi kesan dokumen resmi, bukan landing page marketing)
5. **Motion minimal** — hanya satu reveal halus saat hero load (fade+garis merah memanjang dari atas), tidak ada fade-in bertingkat di tiap card

## 5. Komponen Kunci

- **Berita Card**: tanpa border-radius besar, foto 4:3, garis bawah tipis Abu Garis, meta (kategori · tanggal) pakai IBM Plex Mono kecil, bukan all-caps
- **Badge status PPDB**: kotak kecil radius 2px, Merah Rapor jika dibuka, Abu Garis jika tutup — bukan pill rounded penuh
- **Tombol utama**: persegi radius 2px, Tinta background + teks Kertas, hover invert (border Tinta, background transparan) — bukan gradient
- **Tombol sekunder**: outline 1px Tinta, transparan
- **Statistik**: angka besar IBM Plex Serif + label kecil di bawahnya (bukan di samping), dipisah garis vertikal tipis antar-statistik seperti kolom tabel

## 6. Import Font (Google Fonts)

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@500&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Serif:wght@600;700&display=swap" rel="stylesheet">
```

```css
:root {
  --color-paper: #EDEAD9;
  --color-paper-alt: #FBFAF5;
  --color-ink: #1F2A44;
  --color-red: #9B3226;
  --color-gold: #C99A3E;
  --color-line: #A79E8C;
  --color-green: #2F4A3C;

  --font-display: 'IBM Plex Serif', serif;
  --font-body: 'IBM Plex Sans', sans-serif;
  --font-mono: 'IBM Plex Mono', monospace;
}
```

Lihat `homepage-template.html` untuk implementasi penuh siap-pakai (tinggal dipecah jadi Blade partials).
