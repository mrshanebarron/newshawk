<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Article;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::withCount('articles')
            ->orderByDesc('articles_count')
            ->get();

        return view('topics.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        $articles = $topic->articles()
            ->with('source')
            ->orderByDesc('published_at')
            ->paginate(12);

        $sentimentBreakdown = [
            'positive' => $topic->articles()->where('sentiment_label', 'positive')->count(),
            'neutral' => $topic->articles()->where('sentiment_label', 'neutral')->count(),
            'negative' => $topic->articles()->where('sentiment_label', 'negative')->count(),
        ];

        $topSources = $topic->articles()
            ->select('source_id')
            ->selectRaw('count(*) as cnt')
            ->groupBy('source_id')
            ->orderByDesc('cnt')
            ->limit(5)
            ->with('source')
            ->get();

        return view('topics.show', compact('topic', 'articles', 'sentimentBreakdown', 'topSources'));
    }
}
