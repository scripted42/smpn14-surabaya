<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'name',
        'is_anonymous',
        'category',
        'role',
        'email',
        'phone',
        'title',
        'content',
        'attachment',
        'status',
        'response',
        'responded_at',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'is_read' => 'boolean',
            'responded_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public const CATEGORIES = [
        'kritik_saran' => 'Kritik & Saran',
        'fasilitas' => 'Fasilitas & Sarana Prasarana',
        'akademik' => 'Akademik & Pembelajaran',
        'bullying' => 'Laporan Perundungan (Anti-Bullying)',
        'pelayanan' => 'Pelayanan & Administrasi Tata Usaha',
        'lainnya' => 'Aspirasi / Masukan Lainnya',
    ];

    public const ROLES = [
        'siswa' => 'Peserta Didik (Siswa)',
        'wali_murid' => 'Orang Tua / Wali Murid',
        'guru_staf' => 'Guru / Tenaga Kependidikan',
        'alumni' => 'Alumni SMPN 14',
        'masyarakat' => 'Masyarakat Umum / Pemerhati',
    ];

    public const STATUSES = [
        'pending' => 'Menunggu Verifikasi',
        'diproses' => 'Sedang Ditindaklanjuti',
        'selesai' => 'Selesai Ditindaklanjuti',
        'ditolak' => 'Tidak Dapat Ditindaklanjuti',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    public function getRoleLabelAttribute(): string
    {
        return self::ROLES[$this->role] ?? ucfirst($this->role);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
            default => 'gray',
        };
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Anonim (Nama Disamarkan)';
        }

        return $this->name;
    }

    public static function generateTicketNumber(): string
    {
        do {
            $ticket = 'ASP-' . date('ym') . '-' . strtoupper(Str::random(4));
        } while (self::where('ticket_number', $ticket)->exists());

        return $ticket;
    }
}

