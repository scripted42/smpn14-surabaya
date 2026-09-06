<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Facility;
use App\Models\News;
use App\Models\PpdbSetting;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the school homepage.
     */
    public function index(): View
    {
        // 6 latest published news (cached for 10 minutes)
        $news = \Illuminate\Support\Facades\Cache::remember('homepage_news', 600, function () {
            return News::published()
                ->with(['category', 'media'])
                ->latest('published_at')
                ->take(6)
                ->get();
        });

        // Active PPDB setting with timelines
        $ppdb = PpdbSetting::with(['timelines' => function ($q) {
            $q->orderBy('sort_order', 'asc');
        }])->latest()->first();

        // 3 approved testimonials
        $testimonials = Testimonial::approved()
            ->with('media')
            ->latest()
            ->take(3)
            ->get();

        // Facilities (first 4 for homepage showcase)
        $facilities = Facility::with('media')
            ->orderBy('sort_order', 'asc')
            ->take(4)
            ->get();

        // Achievements for current year statistics
        $currentYear = (int) date('Y');
        $achievements = Achievement::with(['category', 'media'])
            ->where('year', '>=', $currentYear - 1)
            ->latest('year')
            ->take(4)
            ->get();

        // General settings
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        // Structural leader (Kepala Sekolah)
        $principal = Teacher::where('is_structural', true)
            ->orderBy('sort_order', 'asc')
            ->first();

        return view('home', compact(
            'news',
            'ppdb',
            'testimonials',
            'facilities',
            'achievements',
            'settings',
            'principal'
        ));
    }
}
