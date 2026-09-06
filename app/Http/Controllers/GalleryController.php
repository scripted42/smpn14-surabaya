<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Display listing of school event galleries.
     */
    public function index(): View
    {
        $galleries = Gallery::with(['media', 'photos', 'videos'])
            ->latest('event_date')
            ->paginate(8);

        return view('gallery.index', compact('galleries'));
    }

    /**
     * Display a specific gallery album.
     */
    public function show(string $slug): View
    {
        $gallery = Gallery::with([
            'media',
            'photos' => function ($q) {
                $q->orderBy('sort_order', 'asc');
            },
            'photos.media',
            'videos'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        return view('gallery.show', compact('gallery'));
    }
}
