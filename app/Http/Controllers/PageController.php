<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use App\Models\Page;
use App\Models\Teacher;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the school profile page (history, vision-mission, structural team).
     */
    public function profile(): View
    {
        $sejarah = Page::where('slug', 'sejarah')->first();
        $visiMisi = Page::where('slug', 'visi-misi')->first();
        $tataTertib = Page::where('slug', 'tata-tertib')->first();

        $structuralTeachers = Teacher::where('is_structural', true)
            ->with('media')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('pages.profile', compact('sejarah', 'visiMisi', 'tataTertib', 'structuralTeachers'));
    }

    /**
     * Display the academic page (curriculum, extracurriculars).
     */
    public function academic(): View
    {
        $kurikulum = Page::where('slug', 'kurikulum')->first();

        $extracurriculars = Extracurricular::with('media')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('pages.academic', compact('kurikulum', 'extracurriculars'));
    }
}
