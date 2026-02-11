@extends('layouts.app')
@section('title', 'Topics — NewsHawk')

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
                    <span style="color: var(--text-primary);">Topics</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div style="margin-bottom: 1.5rem;" class="reveal">
                <h2 class="font-display" style="font-size: 1.4rem; margin-bottom: 0.25rem;">Monitored Topics</h2>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">{{ $topics->where('is_active', true)->count() }} active topics tracking {{ $topics->sum('articles_count') }} articles</p>
            </div>

            <div class="grid-3" style="margin-bottom: 1.5rem;">
                @foreach($topics as $topic)
                <a href="{{ route('topics.show', $topic) }}" class="card reveal" style="text-decoration: none; color: inherit; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: {{ $topic->color }};"></div>
                    <div class="card-body" style="padding: 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <span style="font-size: 1.25rem;">{{ $topic->category_icon }}</span>
                            <h3 class="font-display" style="font-size: 1rem;">{{ $topic->name }}</h3>
                            @if(!$topic->is_active)
                            <span class="badge badge-slate" style="margin-left: auto;">Paused</span>
                            @endif
                        </div>
                        <div style="font-size: 0.78rem; color: var(--text-secondary); margin-bottom: 0.75rem;">
                            {{ Str::limit($topic->keywords, 80) }}
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <span class="badge badge-{{ $topic->category_color }}">{{ ucfirst($topic->category ?? 'general') }}</span>
                                <span class="badge badge-slate" style="margin-left: 0.25rem;">{{ $topic->frequency_label }}</span>
                            </div>
                            <div class="font-mono" style="font-size: 0.8rem; font-weight: 600; color: {{ $topic->color }};">
                                {{ $topic->articles_count }}
                            </div>
                        </div>
                        @if($topic->last_scanned_at)
                        <div style="font-size: 0.65rem; color: var(--text-muted); margin-top: 0.5rem;">
                            Last scan: {{ $topic->last_scanned_at->diffForHumans() }}
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
