<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    /**
     * Tampilkan formulir aduan/aspirasi dan pelacakan tiket.
     */
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('complaints.index', compact('settings'));
    }

    /**
     * Simpan aduan/aspirasi baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $isAnonymous = $request->boolean('is_anonymous');

        $rules = [
            'is_anonymous' => 'nullable|boolean',
            'role' => 'required|string|in:' . implode(',', array_keys(Complaint::ROLES)),
            'category' => 'required|string|in:' . implode(',', array_keys(Complaint::CATEGORIES)),
            'email' => 'nullable|email|max:120',
            'phone' => 'nullable|string|max:30',
            'title' => 'required|string|max:200',
            'content' => 'required|string|min:10|max:4000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ];

        if (! $isAnonymous) {
            $rules['name'] = 'required|string|max:120';
        } else {
            $rules['name'] = 'nullable|string|max:120';
        }

        $validated = $request->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi jika tidak memilih opsi anonim.',
            'role.required' => 'Pilih kategori identitas Anda (siswa, wali murid, dll).',
            'category.required' => 'Pilih kategori aspirasi / aduan.',
            'title.required' => 'Judul / perihal aduan wajib diisi.',
            'content.required' => 'Isi uraian aspirasi / aduan wajib diisi.',
            'content.min' => 'Uraian pesan minimal 10 karakter.',
            'attachment.max' => 'Ukuran berkas lampiran maksimal 5MB.',
            'attachment.mimes' => 'Format berkas lampiran harus berupa JPG, PNG, WebP, atau PDF.',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
        }

        $ticketNumber = Complaint::generateTicketNumber();
        $name = $isAnonymous && empty($validated['name']) ? 'Anonim' : ($validated['name'] ?? 'Anonim');

        $complaint = Complaint::create([
            'ticket_number' => $ticketNumber,
            'name' => $name,
            'is_anonymous' => $isAnonymous,
            'role' => $validated['role'],
            'category' => $validated['category'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'attachment' => $attachmentPath,
            'status' => 'pending',
            'is_read' => false,
        ]);

        return redirect()->route('complaint.index')
            ->with('complaint_success', true)
            ->with('ticket_number', $ticketNumber)
            ->with('success', 'Aspirasi / pengaduan Anda berhasil dikirim ke pihak SMP Negeri 14 Surabaya.');
    }

    /**
     * Lacak status aduan berdasarkan nomor tiket.
     */
    public function track(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ticket_number' => 'required|string|max:50',
        ], [
            'ticket_number.required' => 'Masukkan nomor tiket aduan Anda.',
        ]);

        $ticket = strtoupper(trim($validated['ticket_number']));
        $complaint = Complaint::where('ticket_number', $ticket)->first();

        if (! $complaint) {
            return redirect()->route('complaint.index', ['#lacak'])
                ->with('track_error', 'Nomor tiket "' . e($ticket) . '" tidak ditemukan. Mohon periksa kembali kode tiket Anda.')
                ->withInput();
        }

        return redirect()->route('complaint.index', ['#lacak'])
            ->with('track_result', $complaint)
            ->withInput();
    }
}

