<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Display directory of teachers and staff.
     */
    public function index(Request $request): View
    {
        $filter = $request->query('kategori'); // all, struktural, guru, staf
        $search = $request->query('q');

        $query = Teacher::with('media')->orderBy('sort_order', 'asc')->orderBy('name', 'asc');

        if ($filter === 'struktural') {
            $query->where('is_structural', true);
        } elseif ($filter === 'guru') {
            $query->whereNotNull('subject');
        } elseif ($filter === 'staf') {
            $query->whereNull('subject')->where('position', 'like', '%Tata Usaha%');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $teachers = $query->get();

        return view('teachers.index', compact('teachers', 'filter', 'search'));
    }
}
