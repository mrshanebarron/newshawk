@extends('layouts.app')
@section('title', 'Sources — NewsHawk')

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
                    <span style="color: var(--text-primary);">Sources</span>
                </div>
            </div>
        </div>

        <div class="content-area">
            <div class="reveal" style="margin-bottom: 1.5rem;">
                <h2 class="font-display" style="font-size: 1.4rem; margin-bottom: 0.25rem;">News Sources</h2>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">{{ $sources->count() }} sources monitored · {{ $sources->sum('articles_count') }} total articles collected</p>
            </div>

            <div class="card reveal">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Category</th>
                            <th>Country</th>
                            <th>Reliability</th>
                            <th style="text-align: right;">Articles</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sources as $source)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--text-primary);">{{ $source->name }}</div>
                                <div style="font-size: 0.7rem; color: var(--text-muted);">{{ $source->domain }}</div>
                            </td>
                            <td>
                                <span class="badge badge-slate">{{ $source->category_label }}</span>
                            </td>
                            <td style="font-size: 0.8rem;">{{ $source->country ?? '—' }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 60px; height: 5px; background: var(--bg-elevated); border-radius: 3px; overflow: hidden;">
                                        <div style="width: {{ ($source->reliability_score / 10) * 100 }}%; height: 100%; background: var(--{{ $source->reliability_color }}); border-radius: 3px;"></div>
                                    </div>
                                    <span class="font-mono" style="font-size: 0.75rem; color: var(--{{ $source->reliability_color }});">{{ $source->reliability_score }}</span>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <span class="font-mono" style="font-weight: 600;">{{ number_format($source->articles_count) }}</span>
                            </td>
                            <td>
                                @if($source->is_active)
                                <span class="badge badge-emerald">Active</span>
                                @else
                                <span class="badge badge-slate">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
