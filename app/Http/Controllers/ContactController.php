<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageNotification;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the contact form and school information.
     */
    public function index(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('contact.index', compact('settings'));
    }

    /**
     * Store a newly created contact message.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek pesan wajib diisi.',
            'message.required' => 'Isi pesan wajib diisi.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        $contactMessage = ContactMessage::create($validated);

        // Attempt sending email notification to admin
        try {
            $adminEmail = Setting::where('key', 'email')->value('value') ?? config('mail.from.address');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new ContactMessageNotification($contactMessage));
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email notifikasi pesan kontak: ' . $e->getMessage());
        }

        return redirect()->route('contact.index')
            ->with('success', 'Terima kasih, pesan Anda telah berhasil terkirim kepada pihak sekolah. Kami akan segera menindaklanjuti.');
    }
}
