@php
    $campaignSettings = $settings ?? \App\Models\Setting::all()->pluck('value', 'key')->toArray();
    $cActive = ($campaignSettings['campaign_popup_active'] ?? '1') == '1';
    $cBadge = $campaignSettings['campaign_popup_badge'] ?? 'Suara Warga · Layanan Terbuka';
    $cTitle = $campaignSettings['campaign_popup_title'] ?? 'Layanan Aduan, Kritik & Saran Sekolah';
    $cSubtitle = $campaignSettings['campaign_popup_subtitle'] ?? 'Kanal Resmi Aspirasi & Pengaduan SMP Negeri 14 Surabaya';
    $cDesc = $campaignSettings['campaign_popup_description'] ?? 'SMP Negeri 14 Surabaya membuka ruang keterbukaan untuk menampung aspirasi, kritik, saran, maupun aduan demi peningkatan mutu pendidikan dan fasilitas sekolah.';
    $cImage = !empty($campaignSettings['campaign_popup_image']) ? asset('storage/' . $campaignSettings['campaign_popup_image']) : null;
    $cBtnText = !empty($campaignSettings['campaign_popup_btn_text']) ? $campaignSettings['campaign_popup_btn_text'] : 'Kirim Aspirasi / Aduan Sekarang';
    $cBtnUrl = !empty($campaignSettings['campaign_popup_btn_url']) ? $campaignSettings['campaign_popup_btn_url'] : route('complaint.index');
    $cCloseText = !empty($campaignSettings['campaign_popup_secondary_text']) ? $campaignSettings['campaign_popup_secondary_text'] : 'Nanti Saja';
    $cFreq = $campaignSettings['campaign_popup_frequency'] ?? 'once_per_session';
@endphp

@if($cActive)
<!-- Campaign Popout Modal -->
<div id="campaign-popout-backdrop" class="campaign-backdrop" style="display:none;" onclick="handleBackdropClick(event)">
    <div class="campaign-modal-card" id="campaign-modal-card">
        
        <!-- Tombol Tutup Silang -->
        <button type="button" class="campaign-modal-close" onclick="closeCampaignPopout()" aria-label="Tutup Popout">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <!-- Optional Banner Image -->
        @if($cImage)
            <div class="campaign-modal-image-wrap">
                <img src="{{ $cImage }}" alt="{{ $cTitle }}" class="campaign-modal-image">
            </div>
        @endif

        <div class="campaign-modal-body">
            @if($cBadge)
                <div class="campaign-badge">
                    <span class="campaign-badge-dot"></span>
                    <span>{{ $cBadge }}</span>
                </div>
            @endif

            <h3 class="campaign-modal-title">
                {{ $cTitle }}
            </h3>

            @if($cSubtitle)
                <div class="campaign-modal-subtitle">
                    {{ $cSubtitle }}
                </div>
            @endif

            <p class="campaign-modal-desc">
                {{ $cDesc }}
            </p>

            <div class="campaign-modal-actions">
                <a href="{{ $cBtnUrl }}" class="campaign-btn-primary" onclick="closeCampaignPopout()">
                    <span>{{ $cBtnText }}</span>
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
                <button type="button" class="campaign-btn-secondary" onclick="closeCampaignPopout()">
                    {{ $cCloseText }}
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Hook Pill (Akselerator / Hook di pojok layar) -->
<div id="campaign-floating-hook" class="campaign-floating-hook" onclick="openCampaignPopout()" title="{{ $cTitle }}">
    <div class="floating-hook-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
    </div>
    <div class="floating-hook-text">
        <span class="floating-hook-sub">Aspirasi &amp; Aduan</span>
        <span class="floating-hook-main">{{ Str::limit($cTitle, 22) }}</span>
    </div>
    <div class="floating-hook-pulse"></div>
</div>

<style>
/* Popout Modal Styles */
.campaign-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(10, 24, 46, 0.65);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.campaign-backdrop.active {
    opacity: 1;
}

.campaign-modal-card {
    background: #FFFFFF;
    border-radius: 6px;
    width: 100%;
    max-width: 520px;
    box-shadow: 0 20px 40px -10px rgba(10, 24, 46, 0.4), 0 0 0 1px rgba(10, 24, 46, 0.1);
    position: relative;
    overflow: hidden;
    transform: translateY(20px) scale(0.97);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    border-top: 4px solid var(--color-teal);
}

.campaign-backdrop.active .campaign-modal-card {
    transform: translateY(0) scale(1);
}

.campaign-modal-close {
    position: absolute;
    top: 14px;
    right: 14px;
    background: rgba(255, 255, 255, 0.85);
    border: 1px solid #E2E8F0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748B;
    cursor: pointer;
    transition: all 0.15s ease;
    z-index: 10;
}

.campaign-modal-close:hover {
    background: #F1F5F9;
    color: var(--color-ink);
    transform: rotate(90deg);
}

.campaign-modal-image-wrap {
    width: 100%;
    max-height: 200px;
    overflow: hidden;
    border-bottom: 1px solid #E2E8F0;
}

.campaign-modal-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.campaign-modal-body {
    padding: 30px 28px 26px 28px;
}

.campaign-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: var(--color-teal-bg);
    color: var(--color-teal-dark);
    font-size: 11px;
    font-weight: 700;
    font-family: var(--font-mono);
    padding: 4px 10px;
    border-radius: 3px;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.campaign-badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--color-teal);
    animation: hookPulse 1.8s infinite;
}

.campaign-modal-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 700;
    color: var(--color-ink);
    margin: 0 0 6px 0;
    line-height: 1.25;
}

.campaign-modal-subtitle {
    font-size: 13px;
    font-weight: 600;
    color: var(--color-teal);
    margin-bottom: 12px;
    font-family: var(--font-body);
}

.campaign-modal-desc {
    font-size: 14px;
    color: #475569;
    line-height: 1.6;
    margin: 0 0 24px 0;
}

.campaign-modal-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
}

.campaign-btn-primary {
    background: var(--color-ink);
    color: #FFFFFF !important;
    font-size: 14px;
    font-weight: 600;
    padding: 11px 20px;
    border-radius: 4px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: background 0.15s ease, transform 0.1s ease;
}

.campaign-btn-primary:hover {
    background: var(--color-teal);
    transform: translateY(-1px);
}

.campaign-btn-secondary {
    background: transparent;
    color: #64748B;
    border: 1px solid #CBD5E1;
    font-size: 13px;
    font-weight: 500;
    padding: 10px 18px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.15s ease;
}

.campaign-btn-secondary:hover {
    background: #F8FAFC;
    color: var(--color-ink);
    border-color: #94A3B8;
}

/* Floating Hook Pill in Bottom Right Corner */
.campaign-floating-hook {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background: #FFFFFF;
    border: 1px solid #CBD5E1;
    box-shadow: 0 10px 25px -5px rgba(10, 24, 46, 0.2);
    border-radius: 30px;
    padding: 8px 16px 8px 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    z-index: 9999;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    border-left: 4px solid var(--color-teal);
}

.campaign-floating-hook:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 14px 30px -5px rgba(10, 24, 46, 0.3);
    border-color: var(--color-teal);
}

.floating-hook-icon {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--color-teal-bg);
    color: var(--color-teal);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.floating-hook-text {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.floating-hook-sub {
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--color-teal);
    font-family: var(--font-mono);
    line-height: 1.2;
}

.floating-hook-main {
    font-size: 13px;
    font-weight: 600;
    color: var(--color-ink);
    line-height: 1.2;
}

.floating-hook-pulse {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10B981;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: pulseEmerald 2s infinite;
}

@keyframes pulseEmerald {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
    }
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
}

@keyframes hookPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.85); }
}

@media (max-width: 640px) {
    .campaign-floating-hook {
        bottom: 16px;
        right: 16px;
        padding: 6px 12px 6px 8px;
    }
    .floating-hook-main {
        max-width: 130px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .campaign-modal-body {
        padding: 24px 18px 20px 18px;
    }
    .campaign-modal-title {
        font-size: 19px;
    }
}
</style>

<script>
const CAMPAIGN_STORAGE_KEY = 'smpn14_campaign_popout_dismissed';
const CAMPAIGN_FREQUENCY = '{{ $cFreq }}';

function openCampaignPopout() {
    const backdrop = document.getElementById('campaign-popout-backdrop');
    if (!backdrop) return;
    backdrop.style.display = 'flex';
    requestAnimationFrame(() => {
        backdrop.classList.add('active');
    });
}

function closeCampaignPopout() {
    const backdrop = document.getElementById('campaign-popout-backdrop');
    if (!backdrop) return;
    backdrop.classList.remove('active');
    setTimeout(() => {
        backdrop.style.display = 'none';
    }, 250);

    // Tandai jika hanya sekali per sesi
    if (CAMPAIGN_FREQUENCY === 'once_per_session') {
        try {
            sessionStorage.setItem(CAMPAIGN_STORAGE_KEY, '1');
        } catch(e) {}
    }
}

function handleBackdropClick(e) {
    if (e.target.id === 'campaign-popout-backdrop') {
        closeCampaignPopout();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Cek apakah popout otomatis harus tampil
    let isDismissed = false;
    if (CAMPAIGN_FREQUENCY === 'once_per_session') {
        try {
            isDismissed = sessionStorage.getItem(CAMPAIGN_STORAGE_KEY) === '1';
        } catch(e) {}
    }

    // Jika belum ditutup pada sesi ini, munculkan otomatis setelah 700ms
    if (!isDismissed) {
        setTimeout(function() {
            openCampaignPopout();
        }, 700);
    }
});
</script>
@endif
