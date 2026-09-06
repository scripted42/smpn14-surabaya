<?php

namespace App\Http\Controllers;

use App\Models\PpdbSetting;
use Illuminate\View\View;

class PpdbController extends Controller
{
    /**
     * Display the official PPDB / SPMB Surabaya information page.
     */
    public function index(): View
    {
        $ppdb = PpdbSetting::with([
            'timelines' => function ($q) {
                $q->orderBy('sort_order', 'asc');
            },
            'faqs' => function ($q) {
                $q->orderBy('sort_order', 'asc');
            }
        ])->latest()->first();

        return view('ppdb.index', compact('ppdb'));
    }
}
