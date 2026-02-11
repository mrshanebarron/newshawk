<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Source;
use App\Models\Topic;

class ArticleController extends Controller
{
    public function index()
    {
        $query = Article::with(['source', 'topics'])->orderByDesc('published_at');

        if (request('topic')) {
            $query->whereHas('topics', fn($q) => $q->where('slug', request('topic')));
        }
        if (request('source')) {
            $query->whereHas('source', fn($q) => $q->where('slug', request('source')));
        }
        if (request('sentiment')) {
            $query->where('sentiment_label', request('sentiment'));
        }
        if (request('bookmarked')) {
            $query->where('is_bookmarked', true);
        }

        $articles = $query->paginate(15);
        $topics = Topic::where('is_active', true)->orderBy('name')->get();
        $sources = Source::where('is_active', true)->orderBy('name')->get();

        return view('articles.index', compact('articles', 'topics', 'sources'));
    }

    public function show(Article $article)
    {
        $article->load(['source', 'topics', 'alerts']);

        $related = Article::where('id', '!=', $article->id)
            ->whereHas('topics', function ($q) use ($article) {
                $q->whereIn('topics.id', $article->topics->pluck('id'));
            })
            ->with('source')
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        return view('articles.show', compact('article', 'related'));
    }
}
