<?php

namespace Tests\Feature;

use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintTest extends TestCase
{
    use RefreshDatabase;

    public function test_complaint_page_can_be_rendered(): void
    {
        $response = $this->get('/aduan');

        $response->assertStatus(200);
        $response->assertSee('Layanan Aspirasi, Kritik & Pengaduan');
        $response->assertSee('Formulir Aspirasi & Aduan');
        $response->assertSee('Lacak Status Aduan');
    }

    public function test_user_can_submit_complaint(): void
    {
        $response = $this->post('/aduan', [
            'name' => 'Ahmad Fathoni',
            'role' => 'siswa',
            'category' => 'kritik_saran',
            'email' => 'ahmad@example.com',
            'phone' => '081234567890',
            'title' => 'Usulan Ekstrakurikuler Robotika',
            'content' => 'Apakah SMPN 14 Surabaya bisa membuka ekstrakurikuler robotika atau coding untuk siswa kelas VII?',
        ]);

        $response->assertRedirect('/aduan');
        $response->assertSessionHas('complaint_success', true);
        $response->assertSessionHas('ticket_number');

        $this->assertDatabaseHas('complaints', [
            'name' => 'Ahmad Fathoni',
            'role' => 'siswa',
            'category' => 'kritik_saran',
            'title' => 'Usulan Ekstrakurikuler Robotika',
            'status' => 'pending',
            'is_anonymous' => false,
        ]);
    }

    public function test_user_can_submit_complaint_anonymously(): void
    {
        $response = $this->post('/aduan', [
            'is_anonymous' => 1,
            'role' => 'masyarakat',
            'category' => 'fasilitas',
            'title' => 'Lampu Penerangan Lapangan Depan',
            'content' => 'Lampu penerangan di area gerbang depan mohon diganti karena redup saat malam hari.',
        ]);

        $response->assertRedirect('/aduan');
        $response->assertSessionHas('complaint_success', true);

        $this->assertDatabaseHas('complaints', [
            'name' => 'Anonim',
            'is_anonymous' => true,
            'title' => 'Lampu Penerangan Lapangan Depan',
        ]);
    }

    public function test_user_can_track_complaint_by_ticket(): void
    {
        $complaint = Complaint::create([
            'ticket_number' => Complaint::generateTicketNumber(),
            'name' => 'Siti Aminah',
            'role' => 'wali_murid',
            'category' => 'akademik',
            'title' => 'Jadwal Remedial Semester Ganjil',
            'content' => 'Kapan jadwal remedial akan diumumkan untuk kelas VIII?',
            'status' => 'diproses',
            'response' => 'Jadwal akan dipublikasikan oleh kurikulum hari Jumat ini.',
            'responded_at' => now(),
            'is_read' => true,
        ]);

        $response = $this->post('/aduan/lacak', [
            'ticket_number' => $complaint->ticket_number,
        ]);

        $response->assertRedirect('/aduan?#lacak');
        $response->assertSessionHas('track_result');
    }

    public function test_homepage_shows_campaign_popout_and_menu(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('campaign-popout-backdrop');
        $response->assertSee('campaign-floating-hook');
        $response->assertSee('Aduan & Saran');
        $response->assertSee('E-Lapor & Aspirasi');
    }
}

