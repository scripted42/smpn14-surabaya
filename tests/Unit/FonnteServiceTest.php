<?php

namespace Tests\Unit;

use App\Models\Complaint;
use App\Models\Setting;
use App\Services\FonnteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FonnteServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sendMessage_returns_error_if_token_not_configured(): void
    {
        $service = new FonnteService();
        $result = $service->sendMessage('08123456789', 'Halo');

        $this->assertFalse($result['status']);
        $this->assertStringContainsString('Token Fonnte belum dikonfigurasi', $result['message']);
    }

    public function test_sendMessage_calls_fonnte_api_when_token_configured(): void
    {
        Http::fake([
            'https://api.fonnte.com/send' => Http::response([
                'status' => true,
                'target' => ['08123456789'],
                'detail' => 'success',
            ], 200),
        ]);

        Setting::set('fonnte_token', 'dummy_token_123');

        $service = new FonnteService();
        $result = $service->sendMessage('08123456789', 'Tes notifikasi');

        $this->assertTrue($result['status']);
        $this->assertEquals('Pesan WhatsApp berhasil dikirim.', $result['message']);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.fonnte.com/send' &&
                $request->hasHeader('Authorization', 'dummy_token_123') &&
                $request['target'] === '08123456789';
        });
    }

    public function test_sendComplaintNotification_sends_formatted_message_when_active(): void
    {
        Http::fake([
            'https://api.fonnte.com/send' => Http::response([
                'status' => true,
            ], 200),
        ]);

        Setting::set('fonnte_notification_active', '1');
        Setting::set('fonnte_token', 'valid_token_abc');
        Setting::set('fonnte_target_phones', '081339148829');

        $complaint = Complaint::create([
            'ticket_number' => 'ASP-2611-TEST',
            'name' => 'Budi Santoso',
            'is_anonymous' => false,
            'role' => 'siswa',
            'category' => 'fasilitas',
            'phone' => '08999999999',
            'title' => 'Kerusakan Proyektor',
            'content' => 'Proyektor di lab komputer tidak menyala.',
            'status' => 'pending',
            'is_read' => false,
        ]);

        $service = new FonnteService();
        $result = $service->sendComplaintNotification($complaint);

        $this->assertTrue($result['status']);

        Http::assertSent(function ($request) {
            return str_contains($request['message'], 'ASP-2611-TEST') &&
                str_contains($request['message'], 'Kerusakan Proyektor') &&
                $request['target'] === '081339148829';
        });
    }
}
