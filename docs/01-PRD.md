# PRD — Website SMP Negeri 14 Surabaya (Fullstack Laravel)

## 1. Ringkasan Produk

**Nama proyek:** Website Profil & Informasi SMP Negeri 14 Surabaya
**Tujuan:** Menyediakan kanal informasi resmi sekolah (profil, berita, SPMB, akademik) untuk calon siswa, orang tua, dan masyarakat, dengan panel admin yang mudah dipakai operator non-teknis untuk mengelola seluruh konten tanpa menyentuh kode.

**Status arsitektur:** Aplikasi ini **berdiri independen** — tidak terhubung ke sistem lain (termasuk Presensia). Login admin murni internal (Filament/Breeze), tanpa SSO. Keputusan ini disengaja untuk menjaga isolasi kegagalan: gangguan pada website tidak boleh berdampak ke aplikasi operasional lain, dan sebaliknya. SSO lintas-aplikasi bisa dipertimbangkan di kemudian hari kalau jumlah aplikasi sekolah bertambah dan kebutuhannya sudah nyata — bukan sekarang.

**Target pengguna:**
| Peran | Kebutuhan Utama |
|---|---|
| Calon siswa/orang tua | Info PPDB, profil sekolah, kontak, fasilitas |
| Siswa aktif | Pengumuman, jadwal, ekstrakurikuler |
| Guru/Staff (opsional) | Info kepegawaian, unggah materi (fase 2) |
| Operator/Admin TU | Input berita, galeri, pengumuman, kelola PPDB |
| Kepala sekolah | Approval konten (opsional role reviewer) |

**Stack:**
- Backend: Laravel 11
- Admin panel: **Filament 3** (generate CRUD cepat, role & permission built-in via plugin)
- Frontend publik: Blade + Tailwind CSS (server-rendered, SEO-friendly — penting untuk sekolah agar mudah diindeks Google)
- Editor konten: TipTap atau TinyMCE untuk rich text
- Storage gambar: Laravel Filesystem (lokal atau S3-compatible), dengan image optimization (Spatie Media Library direkomendasikan)
- Auth admin: Laravel Breeze/Fortify + Filament Auth
- Deployment: sesuai konteks kamu — aaPanel + GitHub Actions/manual pull + Cloudflare (SSL, cache, tunnel jika perlu)

---

## 2. Modul & Fitur

### 2.1 Modul Publik (Frontend)

| Halaman | Fitur |
|---|---|
| Home | Hero, sambutan kepsek, berita terbaru (6), statistik, fasilitas, program unggulan, testimoni, banner SPMB, galeri preview, CTA kontak |
| Profil | Sejarah, visi-misi, struktur organisasi (dari data guru/staff dengan flag jabatan struktural) |
| Guru & Staff | Grid direktori, filter by jabatan/mapel |
| Akademik | Kurikulum, kalender pendidikan (embed/download PDF), daftar ekstrakurikuler, jenjang kelas VII–IX |
| Berita | List + pagination + filter kategori, halaman detail dengan artikel terkait |
| SPMB (PPDB) | Info sistem zonasi Kota Surabaya, syarat, jadwal timeline resmi Dispendik, link ke portal SPMB Surabaya, FAQ |
| Galeri | Grid album foto/video, lightbox |
| Prestasi | List prestasi siswa/sekolah (kategori: akademik/non-akademik, tingkat: sekolah/kota/provinsi/nasional) |
| Kontak | Form kontak (kirim ke email/DB), peta lokasi, jam operasional |
| Halaman statis dinamis | Slug-based page untuk kebutuhan ad-hoc (misal "Tata Tertib", "Biaya Pendidikan") |

### 2.2 Modul Admin (Panel)

| Modul | Aksi |
|---|---|
| Dashboard | Ringkasan: jumlah berita bulan ini, pesan kontak baru, status PPDB |
| Berita & Artikel | CRUD, rich text editor, upload cover, kategori, tag, status draft/scheduled/published, SEO meta (title/description) |
| Halaman Statis | CRUD by slug, rich text editor |
| Guru & Staff | CRUD, foto, jabatan, mapel, NIP (opsional), urutan tampil |
| Galeri | CRUD album, upload multiple foto, embed video YouTube |
| Pengumuman | CRUD, lampiran file (PDF/doc), tanggal berlaku, target audiens (siswa/ortu/umum) |
| PPDB | Toggle buka/tutup, kelola jalur pendaftaran, timeline tahapan, FAQ, unduhan formulir |
| Prestasi | CRUD, kategori, tingkat, tahun, foto |
| Fasilitas | CRUD, foto, deskripsi |
| Testimoni | CRUD, moderasi (pending/approved) |
| Pesan Kontak | Inbox pesan dari form kontak publik, tandai dibaca/dibalas |
| Pengaturan Umum | Logo, nama sekolah, alamat, kontak, jam operasional, social links, hero settings, analytics ID |
| User & Role | Kelola akun admin, role (Super Admin, Operator, Kepala Sekolah/Reviewer) |
| Log Aktivitas | Audit trail perubahan konten (siapa ubah apa, kapan) — pakai `spatie/laravel-activitylog` |

---

## 3. User Flow Kritis

**Flow: Admin publish berita**
1. Login admin → Menu Berita → Tambah Baru
2. Isi judul (slug auto-generate, bisa diedit manual), pilih kategori, tulis isi via rich editor, upload cover
3. Pilih status: Draft / Publish Sekarang / Jadwalkan
4. Simpan → jika Publish, langsung tampil di `/berita` dan homepage (jika masuk 6 terbaru)

**Flow: Calon siswa cek PPDB**
1. Buka homepage → klik banner PPDB (hanya tampil jika `ppdb_settings.is_open = true`)
2. Lihat jalur, syarat, timeline
3. Klik CTA → diarahkan ke form pendaftaran eksternal (Google Form/sistem PPDB terpisah) atau form internal (fase 2)

**Flow: Pengunjung kirim pesan kontak**
1. Isi form di `/kontak` → validasi → simpan ke tabel `contact_messages` + kirim notifikasi email ke admin
2. Admin lihat di inbox panel, bisa balas manual via email/WA

---

## 4. Non-Functional Requirements

- **SEO**: server-side rendering (Blade, bukan SPA murni), meta tag dinamis per halaman, sitemap.xml, robots.txt
- **Performance**: image lazy-load, optimasi gambar (WebP), cache halaman berita (Laravel cache/Cloudflare edge cache)
- **Aksesibilitas**: kontras warna AA, fokus keyboard terlihat, alt text wajib di upload gambar
- **Keamanan**: rate limiting form kontak, sanitasi HTML dari rich editor (hindari XSS), CSRF protection bawaan Laravel, 2FA untuk admin (opsional fase 2)
- **Mobile-first**: karena mayoritas calon siswa/ortu akses via HP
- **Multi-bahasa**: opsional fase 2 (ID/EN) — desain struktur DB sudah siap kalau mau nambah `locale` column

---

## 5. Fase Pengembangan

| Fase | Cakupan |
|---|---|
| Fase 1 (MVP) | Home, Profil, Berita, PPDB info, Galeri, Kontak, Admin CRUD dasar |
| Fase 2 | Role & permission granular, PPDB form internal, log aktivitas, testimoni moderasi |
| Fase 3 | Multi-bahasa, portal siswa/guru (nilai, absensi — bisa terhubung ke Presensia kamu), notifikasi WA/email otomatis |

---

## 6. Struktur Folder Laravel (ringkas)

```
app/
  Filament/
    Resources/
      NewsResource.php
      TeacherResource.php
      GalleryResource.php
      AnnouncementResource.php
      AchievementResource.php
      FacilityResource.php
      TestimonialResource.php
      ContactMessageResource.php
      PpdbSettingResource.php
      PageResource.php
  Models/
    News.php, Category.php, Teacher.php, Gallery.php, GalleryPhoto.php,
    Announcement.php, Achievement.php, Facility.php, Testimonial.php,
    ContactMessage.php, PpdbSetting.php, PpdbTimeline.php, Page.php,
    Setting.php, User.php
  Http/Controllers/
    HomeController.php, NewsController.php, PpdbController.php,
    GalleryController.php, ContactController.php, PageController.php
resources/
  views/
    layouts/app.blade.php
    partials/ (header, footer, hero, news-card, cta-ppdb)
    home.blade.php
    news/index.blade.php, news/show.blade.php
    ppdb.blade.php
    gallery.blade.php
    contact.blade.php
  css/app.css (Tailwind + token kustom, lihat 03-design-system.md)
routes/web.php
database/migrations/ (lihat 02-database-schema.sql)
```

Rekomendasi: gunakan `spatie/laravel-medialibrary` untuk semua upload gambar (cover berita, galeri, foto guru) supaya konsisten dan otomatis generate thumbnail.
