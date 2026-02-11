<?php

namespace App\Http\Controllers;

use App\Models\Source;

class SourceController extends Controller
{
    public function index()
    {
        $sources = Source::withCount('articles')
            ->orderByDesc('articles_count')
            ->get();

        $categories = $sources->groupBy('category');

        return view('sources.index', compact('sources', 'categories'));
    }
}
