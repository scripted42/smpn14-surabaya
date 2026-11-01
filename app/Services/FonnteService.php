<?php

namespace App\Services;

use App\Models\Complaint;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $apiUrl = 'https://api.fonnte.com/send';

    /**
     * Kirim pesan teks melalui Fonnte API.
     */
    public function sendMessage(string $target, string $message): array
    {
        $token = Setting::get('fonnte_token');

        if (empty($token)) {
            return [
                'status' => false,
                'message' => 'Token Fonnte belum dikonfigurasi di Pengaturan Global.',
            ];
        }

        if (empty(trim($target))) {
            return [
                'status' => false,
                'message' => 'Nomor tujuan WhatsApp belum ditentukan.',
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => trim($token),
            ])->timeout(15)->post($this->apiUrl, [
                'target' => trim($target),
                'message' => $message,
                'countryCode' => '62',
            ]);

            $result = $response->json() ?? [];

            if ($response->successful()) {
                Log::info('WhatsApp notification sent via Fonnte successfully', [
                    'target' => $target,
                    'result' => $result,
                ]);

                return [
                    'status' => true,
                    'message' => 'Pesan WhatsApp berhasil dikirim.',
                    'response' => $result,
                ];
            }

            Log::warning('Fonnte API responded with error', [
                'status_code' => $response->status(),
                'response' => $response->body(),
            ]);

            return [
                'status' => false,
                'message' => $result['reason'] ?? $result['message'] ?? 'Gagal mengirim pesan via Fonnte (' . $response->status() . ').',
                'response' => $result,
            ];
        } catch (\Throwable $e) {
            Log::error('Fonnte WhatsApp notification exception: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return [
                'status' => false,
                'message' => 'Terjadi kendala jaringan saat menghubungi Fonnte: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Kirim notifikasi aduan baru ke nomor kesiswaan / target yang ditentukan.
     */
    public function sendComplaintNotification(Complaint $complaint): array
    {
        $isActive = (bool) Setting::get('fonnte_notification_active', false);
        $targets = Setting::get('fonnte_target_phones');

        if (! $isActive || empty($targets)) {
            return [
                'status' => false,
                'message' => 'Notifikasi WhatsApp dinonaktifkan atau nomor tujuan kosong.',
            ];
        }

        $categoryLabel = Complaint::CATEGORIES[$complaint->category] ?? ucfirst($complaint->category);
        $roleLabel = Complaint::ROLES[$complaint->role] ?? ucfirst($complaint->role);
        $senderName = $complaint->is_anonymous ? 'Anonim (Disamarkan)' : $complaint->name;

        // Potong isi pesan jika terlalu panjang untuk notifikasi WA (maksimal 300 karakter)
        $snippetContent = mb_strlen($complaint->content) > 300
            ? mb_substr($complaint->content, 0, 300) . '...'
            : $complaint->content;

        $adminUrl = url('/admin/complaints');

        $message = "🔔 *NOTIFIKASI ADUAN MASUK - SMPN 14 SURABAYA*\n\n"
            . "Telah diterima aspirasi / pengaduan baru melalui website resmi:\n\n"
            . "🎫 *Kode Tiket:* `{$complaint->ticket_number}`\n"
            . "🏷️ *Kategori:* {$categoryLabel}\n"
            . "👤 *Pengirim:* {$senderName} ({$roleLabel})\n"
            . (! empty($complaint->phone) ? "📞 *Kontak Pelapor:* {$complaint->phone}\n" : '')
            . "📌 *Perihal:* {$complaint->title}\n\n"
            . "📝 *Uraian Ringkas:*\n"
            . "\"{$snippetContent}\"\n\n"
            . "Silakan login ke panel admin untuk membaca detail & menindaklanjuti:\n"
            . "🔗 {$adminUrl}\n\n"
            . "📅 Waktu: " . now()->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') . " WIB";

        return $this->sendMessage($targets, $message);
    }
}

