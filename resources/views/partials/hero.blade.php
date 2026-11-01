@php
    $rawImages = $settings['hero_images'] ?? ($settings['hero_image'] ?? null);
    $heroPhotos = [];

    if ($rawImages) {
        $decoded = is_string($rawImages) ? json_decode($rawImages, true) : $rawImages;
        $imageList = is_array($decoded) ? $decoded : [$rawImages];

        foreach ($imageList as $path) {
            if (empty($path)) continue;
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                $heroPhotos[] = asset('storage/' . $path);
            } elseif (file_exists(public_path('storage/' . $path))) {
                $heroPhotos[] = asset('storage/' . $path);
            } elseif (file_exists(public_path($path))) {
                $heroPhotos[] = asset($path);
            } else {
                $heroPhotos[] = str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
            }
        }
    }

    $hasHeroPhoto = count($heroPhotos) > 0;
    $isSlider = count($heroPhotos) > 1;
@endphp

@push('styles')
<style>
/* Hero Carousel & Slider */
.hero-carousel {
    position: relative;
    width: 100%;
    min-height: 280px;
    height: 100%;
    overflow: hidden;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 991px) {
    .hero-carousel {
        min-height: 220px;
        max-height: 280px;
    }
}

.hero-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.65s cubic-bezier(0.4, 0, 0.2, 1), transform 0.65s cubic-bezier(0.4, 0, 0.2, 1);
    transform: scale(1.02);
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-slide.active {
    opacity: 1;
    visibility: visible;
    transform: scale(1);
    position: relative;
}

.hero-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    border-radius: 6px;
}

/* Dots Indicator Pill ("...") */
.hero-slider-dots-wrap {
    position: absolute;
    bottom: 12px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 10;
    pointer-events: none;
}

.hero-slider-dots {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(10, 24, 46, 0.68);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.22);
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
    pointer-events: auto;
}

.hero-slider-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.45);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hero-slider-dot:hover {
    background: rgba(255, 255, 255, 0.85);
    transform: scale(1.2);
}

.hero-slider-dot.active {
    width: 22px;
    border-radius: 10px;
    background: var(--color-gold, #D4A03A);
    box-shadow: 0 0 8px rgba(212, 160, 58, 0.7);
}

/* Navigation Arrows (Prev / Next) */
.hero-slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(10, 24, 46, 0.6);
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 9;
    opacity: 0;
    transition: all 0.2s ease;
}

.hero-photo-wrap:hover .hero-slider-arrow {
    opacity: 1;
}

.hero-slider-arrow:hover {
    background: var(--color-teal, #1B7670);
    border-color: var(--color-teal, #1B7670);
    transform: translateY(-50%) scale(1.08);
}

.hero-slider-arrow.prev {
    left: 10px;
}

.hero-slider-arrow.next {
    right: 10px;
}

@media (max-width: 768px) {
    .hero-slider-arrow {
        opacity: 0.85;
        width: 28px;
        height: 28px;
    }
}
</style>
@endpush

<section class="hero" style="position: relative; overflow: hidden; background: linear-gradient(135deg, #0A182E 0%, #132B4F 100%);">
    @if ($hasHeroPhoto)
        {{-- Foto Full di belakang section hero, efek blur dan transparan --}}
        <img id="hero-ambient-bg"
             src="{{ $heroPhotos[0] }}" 
             alt="" 
             style="position: absolute; top: -20px; left: -20px; width: calc(100% + 40px); height: calc(100% + 40px); object-fit: cover; object-position: center; filter: blur(8px); opacity: 0.42; z-index: 0; pointer-events: none; transform: scale(1.05); transition: opacity 0.4s ease-in-out;"
             onerror="this.style.display='none';">

        <div class="container hero-grid" style="position: relative; z-index: 1;">
            {{-- Kartu Teks Sambutan (Desktop: Kiri, Mobile: Bawah Foto) --}}
            <div class="hero-card">
                <h1 class="hero-title">Membentuk siswa Surabaya yang berpikir jernih dan bertindak jujur sejak bangku SMP.</h1>
                <p class="lead hero-lead">
                    SMP Negeri 14 Surabaya membuka ruang belajar akademik dan pembentukan karakter Profil Pelajar Pancasila yang seimbang bagi peserta didik kelas VII hingga IX, dengan rekam jejak lulusan melanjutkan ke SMA/SMK negeri unggulan di Surabaya.
                </p>
                <div class="hero-cta">
                    <a href="{{ url('/ppdb') }}" class="btn-primary" style="background: var(--color-teal); border-color: var(--color-teal); color: #FFF !important;">Informasi SPMB Surabaya</a>
                    <a href="{{ url('/profil') }}" class="btn-outline">Profil Sekolah</a>
                </div>
            </div>

            {{-- Foto Utama / Slider (Desktop: Kanan, Mobile: Tampil di Atas Teks secara Penuh) --}}
            <div class="hero-photo-wrap" id="hero-slider-wrap">
                @if ($isSlider)
                    {{-- Multiple Images Carousel with Autoslide & Dots Indicator --}}
                    <div class="hero-carousel" id="hero-carousel">
                        @foreach ($heroPhotos as $index => $photo)
                            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}">
                                <img src="{{ $photo }}" alt="Foto Banner SMP Negeri 14 Surabaya {{ $index + 1 }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                            </div>
                        @endforeach

                        {{-- Tombol Navigasi Panah Kiri & Kanan --}}
                        <button type="button" class="hero-slider-arrow prev" onclick="prevHeroSlide()" aria-label="Foto Sebelumnya">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <button type="button" class="hero-slider-arrow next" onclick="nextHeroSlide()" aria-label="Foto Selanjutnya">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>

                        {{-- Indikator Titik Tiga "..." / Dots Navigation --}}
                        <div class="hero-slider-dots-wrap">
                            <div class="hero-slider-dots" role="tablist" aria-label="Indikator Banner">
                                @foreach ($heroPhotos as $index => $photo)
                                    <button type="button" 
                                            class="hero-slider-dot {{ $index === 0 ? 'active' : '' }}" 
                                            onclick="goToHeroSlide({{ $index }})" 
                                            data-dot-index="{{ $index }}"
                                            aria-label="Tampilkan Banner {{ $index + 1 }}"
                                            title="Banner {{ $index + 1 }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Single Static Image --}}
                    <img src="{{ $heroPhotos[0] }}" alt="Gedung dan Kegiatan Siswa SMP Negeri 14 Surabaya" onerror="this.onerror=null; this.style.display='none';">
                @endif
            </div>
        </div>
    @else
        {{-- Tampilan saat foto banner utama dihapus / kosong: Hanya menampilkan teks tanpa foto --}}
        <div class="container" style="position: relative; z-index: 1;">
            <div class="hero-card hero-card--solo">
                <h1 class="hero-title hero-title--solo">Membentuk siswa Surabaya yang berpikir jernih dan bertindak jujur sejak bangku SMP.</h1>
                <p class="lead hero-lead">
                    SMP Negeri 14 Surabaya membuka ruang belajar akademik dan pembentukan karakter Profil Pelajar Pancasila yang seimbang bagi peserta didik kelas VII hingga IX, dengan rekam jejak lulusan melanjutkan ke SMA/SMK negeri unggulan di Surabaya.
                </p>
                <div class="hero-cta">
                    <a href="{{ url('/ppdb') }}" class="btn-primary" style="background: var(--color-teal); border-color: var(--color-teal); color: #FFF !important;">Informasi SPMB Surabaya</a>
                    <a href="{{ url('/profil') }}" class="btn-outline">Profil Sekolah</a>
                </div>
            </div>
        </div>
    @endif
</section>

@if ($isSlider)
@push('scripts')
<script>
(function() {
    const heroPhotos = @json($heroPhotos);
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-slider-dot');
    const ambientBg = document.getElementById('hero-ambient-bg');
    const sliderWrap = document.getElementById('hero-slider-wrap');
    
    if (slides.length <= 1) return;

    let currentIndex = 0;
    let autoSlideInterval = null;
    const intervalTime = 4500; // 4.5 detik per slide

    function showSlide(index) {
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;

        currentIndex = index;

        // Update active slide
        slides.forEach((slide, i) => {
            if (i === currentIndex) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        // Update active dot
        dots.forEach((dot, i) => {
            if (i === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });

        // Update ambient blur background
        if (ambientBg && heroPhotos[currentIndex]) {
            ambientBg.style.opacity = '0.15';
            setTimeout(() => {
                ambientBg.src = heroPhotos[currentIndex];
                ambientBg.style.opacity = '0.42';
            }, 250);
        }
    }

    window.goToHeroSlide = function(index) {
        showSlide(index);
        restartAutoslide();
    };

    window.nextHeroSlide = function() {
        showSlide(currentIndex + 1);
        restartAutoslide();
    };

    window.prevHeroSlide = function() {
        showSlide(currentIndex - 1);
        restartAutoslide();
    };

    function startAutoslide() {
        if (autoSlideInterval) clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(() => {
            showSlide(currentIndex + 1);
        }, intervalTime);
    }

    function pauseAutoslide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
            autoSlideInterval = null;
        }
    }

    function restartAutoslide() {
        pauseAutoslide();
        startAutoslide();
    }

    // Pause on hover
    if (sliderWrap) {
        sliderWrap.addEventListener('mouseenter', pauseAutoslide);
        sliderWrap.addEventListener('mouseleave', startAutoslide);

        // Touch swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        sliderWrap.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        sliderWrap.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, { passive: true });

        function handleSwipe() {
            const threshold = 40;
            if (touchEndX < touchStartX - threshold) {
                window.nextHeroSlide();
            } else if (touchEndX > touchStartX + threshold) {
                window.prevHeroSlide();
            }
        }
    }

    // Mulai autoslide
    startAutoslide();
})();
</script>
@endpush
@endif
