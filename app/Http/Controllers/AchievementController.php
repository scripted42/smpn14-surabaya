<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AchievementController extends Controller
{
    /**
     * Display listing of student and school achievements.
     */
    public function index(Request $request): View
    {
        $level = $request->query('tingkat');
        $year = $request->query('tahun');
        $search = $request->query('q');

        $query = Achievement::with(['category', 'media'])->latest('year');

        if ($level) {
            $query->where('level', $level);
        }

        if ($year) {
            $query->where('year', $year);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $achievements = $query->paginate(9)->withQueryString();

        // Get available years for filter
        $availableYears = Achievement::select('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('achievements.index', compact('achievements', 'level', 'year', 'availableYears', 'search'));
    }
}
