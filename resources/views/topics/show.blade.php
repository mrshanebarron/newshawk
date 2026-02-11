@extends('layouts.app')
@section('title', $topic->name . ' — NewsHawk')

@section('body')
<div class="page-wrapper">
    @include('partials.sidebar')

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" @click="sidebarOpen = !sidebarOpen">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div class="topbar-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('topics.index') }}">Topics</a>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                    <span style="color: var(--text-primary);">{{ $topic->name }}</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            <!-- Topic Header -->
            <div class="card reveal" style="margin-bottom: 1.5rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: {{ $topic->color }};"></div>
                <div class="card-body" style="padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <span style="font-size: 1.5rem;">{{ $topic->category_icon }}</span>
                        <div>
                            <h1 class="font-display" style="font-size: 1.5rem;">{{ $topic->name }}</h1>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $topic->frequency_label }} monitoring · {{ $topic->articles_count }} articles tracked</div>
                        </div>
                    </div>
                    <div style="font-size: 0.82rem; color: var(--text-secondary); margin-bottom: 1rem;">
                        <strong style="color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em;">Keywords:</strong>
                        {{ $topic->keywords }}
                    </div>
                    <div style="display: flex; gap: 1.5rem;">
                        @php $total = array_sum($sentimentBreakdown); @endphp
                        @if($total > 0)
                        <div>
                            <div style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.35rem;">Sentiment Distribution</div>
                            <div class="sentiment-bar" style="width: 200px; height: 6px;">
                                <div class="sentiment-positive" style="width: {{ ($sentimentBreakdown['positive'] / $total) * 100 }}%;"></div>
                                <div class="sentiment-neutral" style="width: {{ ($sentimentBreakdown['neutral'] / $total) * 100 }}%;"></div>
                                <div class="sentiment-negative" style="width: {{ ($sentimentBreakdown['negative'] / $total) * 100 }}%;"></div>
                            </div>
                            <div style="display: flex; gap: 1rem; margin-top: 0.35rem; font-size: 0.68rem; color: var(--text-muted);">
                                <span><span style="color: var(--emerald);">●</span> {{ $sentimentBreakdown['positive'] }} positive</span>
                                <span><span style="color: var(--amber);">●</span> {{ $sentimentBreakdown['neutral'] }} neutral</span>
                                <span><span style="color: var(--rose);">●</span> {{ $sentimentBreakdown['negative'] }} negative</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid-sidebar">
                <div>
                    <!-- Articles -->
                    <div class="card reveal">
                        <div class="card-header">
                            <h3>Articles ({{ $articles->total() }})</h3>
                        </div>
                        <div class="card-body" style="padding: 0.25rem 1.25rem;">
                            @forelse($articles as $article)
                            <a href="{{ route('articles.show', $article) }}" class="article-card">
                                <div class="article-meta">
                                    <span style="color: var(--{{ $article->source->reliability_color ?? 'slate' }});">{{ $article->source->name }}</span>
                                    <span>·</span>
                                    <span>{{ $article->published_at->diffForHumans() }}</span>
                                    @if($article->sentiment_score)
                                    <span style="color: var(--{{ $article->sentiment_color }});">{{ $article->sentiment_icon }} {{ $article->sentiment_label }}</span>
                                    @endif
                                </div>
                                <div class="article-title">{{ $article->title }}</div>
                                <div class="article-excerpt">{{ Str::limit($article->summary ?? $article->content, 150) }}</div>
                                @if($article->relevance_score >= 40)
                                <div style="margin-top: 0.3rem;">
                                    <span class="badge badge-{{ $article->relevance_color }}">Relevance: {{ number_format($article->relevance_score) }}%</span>
                                </div>
                                @endif
                            </a>
                            @empty
                            <div style="padding: 2rem; text-align: center; color: var(--text-muted);">No articles found for this topic yet.</div>
                            @endforelse
                        </div>
                    </div>

                    @if($articles->hasPages())
                    <div style="display: flex; justify-content: center; margin-top: 1rem;">
                        {{ $articles->links() }}
                    </div>
                    @endif
                </div>

                <div>
                    <!-- Top Sources for Topic -->
                    @if($topSources->count())
                    <div class="card reveal">
                        <div class="card-header">
                            <h3>Top Sources</h3>
                        </div>
                        <div class="card-body">
                            @foreach($topSources as $ts)
                            <div class="source-bar">
                                <div style="width: 110px; font-size: 0.78rem; font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $ts->source->name }}</div>
                                <div class="source-bar-fill">
                                    <div class="source-bar-fill-inner" style="width: {{ $topSources->max('cnt') > 0 ? ($ts->cnt / $topSources->max('cnt') * 100) : 0 }}%;"></div>
                                </div>
                                <span class="font-mono" style="font-size: 0.7rem; color: var(--text-muted);">{{ $ts->cnt }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
