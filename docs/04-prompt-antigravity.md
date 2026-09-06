# Prompt Antigravity — Website SMPN 14 Surabaya (Fullstack Laravel)

Jalankan bertahap. Selesaikan satu prompt, cek hasilnya, baru lanjut ke prompt berikutnya.
Lampirkan file `02-database-schema.sql` dan `03-design-system.md` sebagai referensi ke Antigravity di setiap tahap yang relevan.

---

## PROMPT 1 — Setup Project & Environment

```
Buatkan project Laravel 11 baru dengan nama "smpn14-surabaya-website".

Install dan konfigurasi:
- Laravel Breeze (untuk auth dasar, kita akan pakai untuk login admin)
- Filament 3 (admin panel) via `filament/filament`
- Tailwind CSS untuk frontend publik (terpisah dari styling internal Filament)
- spatie/laravel-medialibrary (untuk semua upload gambar: cover berita, galeri, foto guru, foto fasilitas)
- spatie/laravel-activitylog (audit trail perubahan konten)

Setelah instalasi:
1. Jalankan migration dasar dan pastikan aplikasi bisa diakses di localhost
2. Buat 1 user admin awal via seeder dengan email admin@smpn14surabaya.sch.id, role 'super_admin'
3. Pastikan panel Filament bisa diakses di /admin dan hanya bisa login dengan akun yang sudah dibuat (bukan register bebas)

Jangan bangun fitur lain dulu di tahap ini — fokus environment jalan dengan bersih.
```

---

## PROMPT 2 — Database & Model

```
Konteks: website profil SMPN 14 Surabaya (jenjang SMP, kelas VII-IX), dengan CMS internal.

Buatkan migration Laravel untuk seluruh tabel berikut (skema lengkap ada di file 02-database-schema.sql yang saya lampirkan — ikuti persis struktur kolom, tipe data, dan foreign key di sana):

- users (tambahkan kolom role: enum super_admin/operator/reviewer)
- settings (key-value untuk pengaturan umum situs)
- categories
- news (berita)
- tags, news_tag (pivot)
- pages (halaman statis)
- teachers (guru & staff)
- galleries, gallery_photos, gallery_videos
- announcements (pengumuman)
- achievements (prestasi) — sesuaikan enum level jika perlu ke konteks SMP
- facilities
- extracurriculars
- testimonials
- ppdb_settings, ppdb_timelines, ppdb_faqs
- contact_messages

Setelah migration, buatkan Eloquent Model untuk masing-masing tabel dengan:
- Relasi yang sesuai (belongsTo, hasMany, belongsToMany) sesuai catatan relasi di file schema
- $fillable yang lengkap sesuai kolom
- Untuk model yang punya gambar (News, Teacher, Gallery, Facility, Testimonial), implementasikan HasMedia dari spatie/laravel-medialibrary dengan media collection 'cover' atau 'photo'
- Untuk News, tambahkan accessor `published` scope (status=published dan published_at <= now())
- Untuk PpdbSetting, tambahkan relasi hasMany ke PpdbTimeline dan PpdbFaq

Buatkan juga factory + seeder dummy data secukupnya (5-8 baris tiap tabel) khusus untuk development, dengan konten realistis sekolah menengah pertama negeri di Surabaya (bukan SMA — jenjang kelas VII, VIII, IX; bukan program peminatan MIPA/IPS).
```

---

## PROMPT 3 — Filament Admin Resources

```
Buatkan Filament Resource untuk seluruh model berikut, dengan form dan table yang proper (bukan generate default kosong):

1. NewsResource — form: title (auto-slug), category (select), rich text editor untuk content (pakai RichEditor bawaan Filament), cover image upload (media library), status (select: draft/scheduled/published), published_at (date time picker, muncul hanya jika status=scheduled), meta_title, meta_description. Table: kolom title, category, status (badge warna: draft=abu, scheduled=kuning, published=hijau), published_at, sortable & searchable di title.

2. TeacherResource — form: name, nip, position, subject, photo upload, bio (textarea), is_structural (toggle), sort_order. Table dengan foto thumbnail, position, is_structural badge.

3. GalleryResource — form: title (auto-slug), description, cover upload, event_date, plus relation manager untuk gallery_photos (multiple upload) dan gallery_videos (input url YouTube).

4. AnnouncementResource — form: title, content (rich text), attachment upload (file, bukan image — accept pdf/doc), audience (select), valid_from, valid_until, is_pinned (toggle).

5. AchievementResource — form: student_name (nullable), title, category, level (select: sekolah/kecamatan/kota/provinsi/nasional/internasional), year, photo upload, description.

6. FacilityResource dan ExtracurricularResource — CRUD sederhana sesuai kolom masing-masing.

7. TestimonialResource — form: name, role (select: siswa/orang_tua/alumni), photo, content (textarea), status (select: pending/approved/rejected). Table dengan filter status, default filter tampilkan 'pending' dulu untuk moderasi.

8. PpdbSettingResource — form: is_open (toggle besar di atas), academic_year, intro_text (rich text), registration_url, requirements (rich text). Sertakan relation manager untuk PpdbTimeline (stage_name, start_date, end_date, sort_order — bisa reorder drag) dan PpdbFaq (question, answer, sort_order).

9. ContactMessageResource — read-only table (disable create/edit), kolom name, email, subject, is_read (toggle langsung dari table), created_at. Action "Tandai dibaca".

10. PageResource — untuk halaman statis (slug-based), form title (auto-slug), content (rich text), is_published toggle.

11. SettingResource — khusus untuk field pengaturan umum (nama sekolah, alamat, telp, email, logo, social media links) — gunakan pendekatan single-record form (bukan table CRUD biasa), karena ini pengaturan global, bukan banyak baris.

Kelompokkan resource ini ke dalam Filament Navigation Groups: "Konten" (News, Pages, Announcements), "Akademik" (Teacher, Achievement, Extracurricular, Facility), "PPDB" (PpdbSetting), "Media" (Gallery, Testimonial), "Sistem" (ContactMessage, Setting, User).

Terapkan role-based access: user dengan role 'operator' tidak bisa akses resource User (kelola akun admin lain) atau Setting (pengaturan global) — hanya super_admin yang bisa.
```

---

## PROMPT 4 — Layout & Homepage Publik

```
Saya sudah punya template desain statis di file homepage-template.html (saya lampirkan) dan panduan design system di 03-design-system.md — ikuti PERSIS token warna, tipografi (IBM Plex Serif/Sans/Mono), spacing, dan struktur visual di file tersebut. Jangan ganti ke desain default Tailwind/shadcn.

Konteks konten: SMPN 14 Surabaya, jenjang SMP (kelas VII, VIII, IX) — BUKAN SMA. Hapus/ubah bagian yang berasumsi SMA:
- Section "Program Peminatan" (MIPA/IPS/Bahasa) ganti jadi "Program Unggulan" berisi hal seperti: Kelas Literasi, Kelas Adiwiyata/Lingkungan, Ekstrakurikuler unggulan — bukan jurusan
- Semua sebutan kelas pakai VII/VIII/IX
- Section PPDB: karena PPDB SMP negeri di Surabaya mengikuti sistem zonasi SPMB Kota Surabaya (bukan pendaftaran mandiri sekolah), ubah copy dan CTA jadi mengarahkan ke: (1) info persyaratan & jadwal SPMB Surabaya versi sekolah ini, dan (2) tombol/link ke portal SPMB resmi Kota Surabaya — bukan form pendaftaran internal

Buatkan:
1. `resources/views/layouts/app.blade.php` — layout utama dengan header, footer, slot content, import font Google Fonts dan CSS token dari design system
2. Pecah homepage-template.html menjadi partials di `resources/views/partials/`: header.blade.php, footer.blade.php, hero.blade.php, news-card.blade.php (component reusable, terima 1 objek $news), ppdb-banner.blade.php, stat-item.blade.php
3. `resources/views/home.blade.php` — rakit dari partials di atas
4. `HomeController@index` — ambil data asli dari database: 6 berita published terbaru, ppdb_settings aktif (is_open), 3 testimonial approved terbaru, semua facilities, semua achievements tahun berjalan untuk hitung statistik jika relevan
5. Route GET / mengarah ke HomeController@index

Pastikan Blade component untuk news-card bisa dipakai ulang juga nanti di halaman /berita (list lengkap).
```

---

## PROMPT 5 — Halaman Publik Lainnya

```
Lanjutkan dari layout dan partials yang sudah ada. Buatkan halaman publik berikut, ikuti design system yang sama (jangan keluar dari token warna/tipografi yang sudah ditetapkan):

1. /berita — list berita published, pagination, filter by kategori (dropdown), pakai news-card component yang sudah dibuat
2. /berita/{slug} — halaman detail: judul, cover, meta info, konten (render HTML dari rich editor dengan aman, gunakan {!! !!} hanya karena sudah disanitasi di layer form request), 3 berita terkait di kategori sama
3. /profil — sejarah, visi-misi dari Page model (slug 'sejarah', 'visi-misi'), struktur organisasi dari Teacher where is_structural=true diurutkan sort_order
4. /guru-staff — grid direktori Teacher, filter by position
5. /akademik — kurikulum (dari Page slug 'kurikulum'), list Extracurricular
6. /ppdb — detail lengkap dari PpdbSetting aktif: intro, requirements, timeline (dari PpdbTimeline diurutkan), FAQ accordion (dari PpdbFaq), CTA ke registration_url atau info SPMB Surabaya
7. /galeri — grid Gallery dengan cover, klik masuk ke /galeri/{slug} menampilkan semua gallery_photos dalam lightbox sederhana dan gallery_videos sebagai embed YouTube
8. /prestasi — list Achievement, filter by level dan tahun
9. /kontak — form (name, email, phone, subject, message) submit ke ContactController@store, validasi server-side, simpan ke contact_messages, tampilkan pesan sukses, kirim notifikasi email ke admin (gunakan Laravel Notification/Mailable sederhana)

Tambahkan meta title dan meta description dinamis di setiap halaman (pakai @section atau komponen SEO sederhana), serta breadcrumb sederhana rata kiri sesuai gaya design system (bukan breadcrumb dengan ikon '>' generic — pakai separator '/' dengan font mono kecil).
```

---

## PROMPT 6 — Finishing: SEO, Cache, Keamanan

```
Tahap finishing sebelum deploy ke aaPanel:

1. Buat sitemap.xml dinamis (route + controller) yang include semua news published dan pages published
2. Buat robots.txt yang allow semua kecuali /admin
3. Tambahkan cache pada query berita homepage dan list (cache::remember 10 menit, invalidasi otomatis saat News disimpan/diupdate via Model Observer)
4. Pastikan semua form (kontak, dan form apapun di admin) sudah terlindungi CSRF (bawaan Laravel, cek tidak ada yang ke-skip)
5. Tambahkan rate limiting pada route POST /kontak (maksimal 3 submit per menit per IP) untuk cegah spam
6. Optimasi gambar: pastikan spatie/laravel-medialibrary generate konversi thumbnail otomatis (300px untuk card, 800px untuk detail) supaya tidak load gambar full-size di semua tempat
7. Buatkan .env.example yang lengkap dengan semua variable yang dibutuhkan (DB, mail, APP_URL, dll) untuk referensi saat deploy ke aaPanel

Jangan ubah struktur atau desain apa pun di tahap ini — murni hardening dan optimasi.
```

---

### Catatan pemakaian

- Tiap prompt sebaiknya jadi 1 sesi terpisah ke Antigravity, jangan digabung — supaya kalau ada yang meleset, gampang dilacak di tahap mana
- Lampirkan `02-database-schema.sql`, `03-design-system.md`, dan `homepage-template.html` sebagai file referensi di prompt yang relevan (2, 3, 4)
- Setelah Prompt 3 selesai, cek dulu isi `/admin` di browser sebelum lanjut ke Prompt 4 — pastikan CRUD-nya jalan dan sesuai ekspektasi sebelum bangun frontend di atasnya
