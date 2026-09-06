-- =========================================================
-- SKEMA DATABASE — WEBSITE SEKOLAH (Laravel Migration Ready)
-- Engine: MySQL 8 / MariaDB
-- Catatan: kolom timestamps (created_at, updated_at) mengikuti
-- konvensi Laravel; soft delete (deleted_at) ditambahkan pada
-- tabel yang butuh riwayat/undo.
-- =========================================================

-- ---------- USERS & ROLE ----------
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin','operator','reviewer') NOT NULL DEFAULT 'operator',
    avatar_path VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- SETTINGS (single-row / key-value) ----------
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,   -- ex: 'school_name', 'address', 'phone', 'email', 'logo_path', 'hero_image', 'social_instagram'
    `value` TEXT NULL,
    `type` ENUM('text','textarea','image','json','boolean') DEFAULT 'text',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- CATEGORIES (dipakai berita, bisa juga prestasi) ----------
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    type ENUM('news','achievement') NOT NULL DEFAULT 'news',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- NEWS / BERITA ----------
CREATE TABLE news (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NULL,
    author_id BIGINT UNSIGNED NULL,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    excerpt VARCHAR(300) NULL,
    content LONGTEXT NOT NULL,           -- HTML dari rich text editor (sanitasi saat simpan)
    cover_path VARCHAR(255) NULL,
    status ENUM('draft','scheduled','published') NOT NULL DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    meta_title VARCHAR(160) NULL,
    meta_description VARCHAR(300) NULL,
    views_count INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status_published (status, published_at)
);

-- tag many-to-many (opsional, fase 2)
CREATE TABLE tags (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(60) NOT NULL,
    slug VARCHAR(80) NOT NULL UNIQUE
);
CREATE TABLE news_tag (
    news_id BIGINT UNSIGNED NOT NULL,
    tag_id BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (news_id, tag_id),
    FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- ---------- STATIC PAGES (slug-based, mis. "sejarah", "tata-tertib") ----------
CREATE TABLE pages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    content LONGTEXT NOT NULL,
    meta_title VARCHAR(160) NULL,
    meta_description VARCHAR(300) NULL,
    is_published BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- TEACHERS & STAFF ----------
CREATE TABLE teachers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    nip VARCHAR(50) NULL,
    position VARCHAR(100) NOT NULL,     -- 'Kepala Sekolah', 'Wakil Kurikulum', 'Guru', 'Staff TU', dst
    subject VARCHAR(100) NULL,          -- mapel yang diampu (nullable untuk staff non-guru)
    photo_path VARCHAR(255) NULL,
    bio TEXT NULL,
    is_structural BOOLEAN DEFAULT FALSE, -- true = tampil di struktur organisasi
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- GALLERY ----------
CREATE TABLE galleries (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(170) NOT NULL UNIQUE,
    description TEXT NULL,
    cover_path VARCHAR(255) NULL,
    event_date DATE NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE TABLE gallery_photos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gallery_id BIGINT UNSIGNED NOT NULL,
    photo_path VARCHAR(255) NOT NULL,
    caption VARCHAR(200) NULL,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (gallery_id) REFERENCES galleries(id) ON DELETE CASCADE
);
CREATE TABLE gallery_videos (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gallery_id BIGINT UNSIGNED NOT NULL,
    youtube_url VARCHAR(255) NOT NULL,
    caption VARCHAR(200) NULL,
    FOREIGN KEY (gallery_id) REFERENCES galleries(id) ON DELETE CASCADE
);

-- ---------- ANNOUNCEMENTS / PENGUMUMAN ----------
CREATE TABLE announcements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    attachment_path VARCHAR(255) NULL,   -- PDF/doc lampiran
    audience ENUM('all','student','parent','staff') DEFAULT 'all',
    valid_from DATE NULL,
    valid_until DATE NULL,
    is_pinned BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- ACHIEVEMENTS / PRESTASI ----------
CREATE TABLE achievements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(150) NULL,      -- null jika prestasi institusi
    title VARCHAR(200) NOT NULL,
    category_id BIGINT UNSIGNED NULL,    -- FK ke categories (type='achievement')
    level ENUM('sekolah','kecamatan','kota','provinsi','nasional','internasional') NOT NULL,
    year YEAR NOT NULL,
    photo_path VARCHAR(255) NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- ---------- FACILITIES / FASILITAS ----------
CREATE TABLE facilities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    photo_path VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- EXTRACURRICULARS / EKSTRAKURIKULER ----------
CREATE TABLE extracurriculars (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    photo_path VARCHAR(255) NULL,
    coach_name VARCHAR(150) NULL,        -- pembina
    schedule_text VARCHAR(150) NULL,     -- ex: 'Setiap Jumat, 14.00-16.00'
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- TESTIMONIALS ----------
CREATE TABLE testimonials (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    role ENUM('siswa','orang_tua','alumni') NOT NULL,
    photo_path VARCHAR(255) NULL,
    content TEXT NOT NULL,
    status ENUM('pending','approved','rejected') DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ---------- PPDB ----------
CREATE TABLE ppdb_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    is_open BOOLEAN DEFAULT FALSE,
    academic_year VARCHAR(20) NOT NULL,       -- ex: '2026/2027'
    intro_text TEXT NULL,
    registration_url VARCHAR(255) NULL,       -- link ke form pendaftaran (internal/eksternal)
    requirements TEXT NULL,                   -- rich text syarat pendaftaran
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE TABLE ppdb_timelines (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ppdb_setting_id BIGINT UNSIGNED NOT NULL,
    stage_name VARCHAR(150) NOT NULL,   -- ex: 'Pendaftaran Gelombang 1'
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (ppdb_setting_id) REFERENCES ppdb_settings(id) ON DELETE CASCADE
);
CREATE TABLE ppdb_faqs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ppdb_setting_id BIGINT UNSIGNED NOT NULL,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (ppdb_setting_id) REFERENCES ppdb_settings(id) ON DELETE CASCADE
);

-- ---------- CONTACT MESSAGES ----------
CREATE TABLE contact_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NULL,
    subject VARCHAR(200) NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL
);

-- ---------- ACTIVITY LOG (opsional, via spatie/laravel-activitylog) ----------
-- Tabel ini otomatis dibuat oleh package, ditulis di sini untuk referensi arsitektur:
-- activity_log(id, log_name, description, subject_type, subject_id, causer_type, causer_id, properties, created_at, updated_at)

-- =========================================================
-- CATATAN RELASI PENTING
-- =========================================================
-- news.category_id          -> categories.id (type='news')
-- achievements.category_id  -> categories.id (type='achievement')
-- news.author_id            -> users.id
-- gallery_photos.gallery_id -> galleries.id (1 galeri banyak foto)
-- ppdb_timelines/faqs       -> ppdb_settings.id (1 tahun ajaran, banyak tahap/FAQ)
-- teachers.is_structural    -> dipakai untuk filter halaman "Struktur Organisasi"
--   (kepala sekolah, wakil, dst tanpa tabel terpisah)
