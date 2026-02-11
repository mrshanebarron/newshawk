@extends('layouts.app')
@section('title', 'Articles — NewsHawk')

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
                    <span style="color: var(--text-primary);">Articles</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            <!-- Filters -->
            <div class="reveal" style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; align-items: center;">
                <span style="font-size: 0.75rem; color: var(--text-muted); margin-right: 0.25rem;">Filter:</span>

                <a href="{{ route('articles.index') }}" class="btn {{ !request('topic') && !request('sentiment') && !request('bookmarked') ? 'btn-primary' : 'btn-ghost' }} btn-sm">All</a>

                @foreach($topics as $topic)
                <a href="{{ route('articles.index', ['topic' => $topic->slug]) }}" class="btn {{ request('topic') === $topic->slug ? 'btn-primary' : 'btn-ghost' }} btn-sm">
                    {{ $topic->name }}
                </a>
                @endforeach

                <span style="width: 1px; height: 20px; background: var(--border-subtle); margin: 0 0.25rem;"></span>

                <a href="{{ route('articles.index', ['sentiment' => 'positive']) }}" class="btn {{ request('sentiment') === 'positive' ? 'btn-primary' : 'btn-ghost' }} btn-sm" style="{{ request('sentiment') === 'positive' ? '' : 'color: var(--emerald);' }}">↑ Positive</a>
                <a href="{{ route('articles.index', ['sentiment' => 'neutral']) }}" class="btn {{ request('sentiment') === 'neutral' ? 'btn-primary' : 'btn-ghost' }} btn-sm" style="{{ request('sentiment') === 'neutral' ? '' : 'color: var(--amber);' }}">→ Neutral</a>
                <a href="{{ route('articles.index', ['sentiment' => 'negative']) }}" class="btn {{ request('sentiment') === 'negative' ? 'btn-primary' : 'btn-ghost' }} btn-sm" style="{{ request('sentiment') === 'negative' ? '' : 'color: var(--rose);' }}">↓ Negative</a>

                <span style="width: 1px; height: 20px; background: var(--border-subtle); margin: 0 0.25rem;"></span>

                <a href="{{ route('articles.index', ['bookmarked' => 1]) }}" class="btn {{ request('bookmarked') ? 'btn-primary' : 'btn-ghost' }} btn-sm">★ Bookmarked</a>
            </div>

            <!-- Article Feed -->
            <div class="card reveal">
                <div class="card-body" style="padding: 0.25rem 1.25rem;">
                    @forelse($articles as $article)
                    <a href="{{ route('articles.show', $article) }}" class="article-card">
                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                            <div style="flex: 1;">
                                <div class="article-meta">
                                    <span style="color: var(--{{ $article->source->reliability_color ?? 'slate' }}); font-weight: 500;">{{ $article->source->name }}</span>
                                    <span>·</span>
                                    <span>{{ $article->published_at->format('M d, H:i') }}</span>
                                    <span>·</span>
                                    <span>{{ $article->published_at->diffForHumans() }}</span>
                                </div>
                                <div class="article-title">
                                    @if($article->is_breaking)<span style="color: var(--rose);">● </span>@endif
                                    @if($article->is_bookmarked)<span style="color: var(--amber);">★ </span>@endif
                                    {{ $article->title }}
                                </div>
                                <div class="article-excerpt">{{ Str::limit($article->summary ?? $article->content, 200) }}</div>
                                <div style="display: flex; gap: 0.35rem; margin-top: 0.5rem; align-items: center;">
                                    @foreach($article->topics as $topic)
                                    <span class="badge badge-{{ $topic->category_color }}">{{ $topic->name }}</span>
                                    @endforeach

                                    @if($article->sentiment_score)
                                    <span class="badge badge-{{ $article->sentiment_color }}" style="margin-left: 0.25rem;">
                                        {{ $article->sentiment_icon }} {{ number_format($article->sentiment_score, 2) }}
                                    </span>
                                    @endif

                                    @if($article->relevance_score >= 50)
                                    <span class="badge badge-{{ $article->relevance_color }}" style="margin-left: auto;">
                                        {{ $article->relevance_label }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div style="padding: 3rem; text-align: center; color: var(--text-muted);">
                        No articles match your filters.
                    </div>
                    @endforelse
                </div>
            </div>

            @if($articles->hasPages())
            <div style="display: flex; justify-content: center; margin-top: 1.5rem;">
                {{ $articles->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
