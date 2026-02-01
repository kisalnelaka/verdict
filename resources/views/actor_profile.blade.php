@extends('layout')

@section('content')
    <div class="animate-fade">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('timeline') }}"
                style="color: var(--accent-toxic); text-decoration: none; font-size: 0.8rem; text-transform: uppercase;">&larr;
                Return to Timeline</a>
        </div>

        <div class="glass" style="padding: 3rem; margin-bottom: 3rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $user->name }}</h1>
                    <p style="color: var(--text-muted);">{{ $user->email }}</p>
                </div>
                <div class="glass" style="padding: 1.5rem; text-align: center; border-color: var(--accent-cyber);">
                    <div
                        style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem;">
                        Wisdom Index</div>
                    <div style="font-size: 2.5rem; font-weight: 800; color: var(--accent-cyber);">{{ $wisdomIndex }}</div>
                </div>
            </div>
        </div>

        <h2 style="margin-bottom: 2rem;">DECISION <span>TRACK RECORD</span></h2>
        <div class="timeline">
            @foreach($decisions as $decision)
                <div class="decision-card glass">
                    <div class="decision-meta">
                        <span
                            class="badge badge-{{ substr($decision->decision_type, 0, 4) }}">{{ $decision->decision_type }}</span>
                        <span>OUTCOMES: {{ $decision->outcomes->count() }}</span>
                    </div>
                    <h3><a href="{{ route('decisions.show', $decision) }}"
                            style="color: inherit; text-decoration: none;">{{ $decision->title }}</a></h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">{{ Str::limit($decision->description, 100) }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection