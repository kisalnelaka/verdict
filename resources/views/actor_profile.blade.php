@extends('layout')

@section('content')
    <div class="animate-fade">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('timeline') }}"
                style="color: var(--accent-toxic); text-decoration: none; font-size: 0.8rem; text-transform: uppercase;">&larr;
                Return to Timeline</a>
        </div>

        <div class="glass" style="padding: 4rem; margin-bottom: 4rem; text-align: center;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 2rem;">
                <div
                    style="width: 80px; height: 80px; background: var(--accent-cyber); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #000; font-weight: 900; box-shadow: 0 0 30px rgba(8, 247, 254, 0.3);">
                    {{ substr($user->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <h1 style="font-size: 3.5rem; margin-bottom: 0.5rem; line-height: 1;">{{ $user->name }}</h1>
                    <p class="monospace" style="color: var(--accent-cyber); font-size: 0.8rem; letter-spacing: 2px;">
                        AUTHOR_ENTITY // {{ strtoupper($user->email) }}</p>
                </div>
                <div class="glass" style="padding: 1.5rem 3rem; text-align: center; border-color: var(--accent-toxic);">
                    <div
                        style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.5rem; letter-spacing: 2px;">
                        Wisdom Index</div>
                    <div style="font-size: 3rem; font-weight: 900; color: var(--accent-toxic);">{{ $wisdomIndex }}</div>
                </div>
            </div>
        </div>

        <h2 style="margin-bottom: 3rem; text-align: center; font-size: 2rem;">DECISION <span>TRACK RECORD</span></h2>
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