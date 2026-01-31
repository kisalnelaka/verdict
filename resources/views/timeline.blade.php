@extends('layout')

@section('content')
    <div class="animate-fade">
        <h1 style="margin-bottom: 2rem; font-weight: 800;">DECISION <span>TIMELINE</span></h1>

        <div class="timeline">
            @forelse($decisions as $decision)
                <div class="decision-card glass">
                    <div class="decision-meta">
                        <span
                            class="badge badge-{{ substr($decision->decision_type, 0, 4) }}">{{ $decision->decision_type }}</span>
                        <span>CONFIDENCE: <strong
                                style="color: var(--accent-toxic)">{{ $decision->confidence_level }}%</strong></span>
                        <span>CREATED: {{ $decision->created_at->format('Y-m-d H:i') }}</span>
                    </div>

                    <h2 style="margin-bottom: 0.5rem;"><a href="{{ route('decisions.show', $decision) }}"
                            style="color: inherit; text-decoration: none;">{{ $decision->title }}</a></h2>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">{{ Str::limit($decision->description, 150) }}
                    </p>

                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">
                            STATUS: <span
                                style="color: {{ $decision->status === 'resolved' ? 'var(--accent-toxic)' : 'var(--accent-cyber)' }}">{{ $decision->status }}</span>
                        </span>
                        <a href="{{ route('decisions.show', $decision) }}" class="btn">Inspect Context</a>
                    </div>
                </div>
            @empty
                <div class="glass" style="padding: 4rem; text-align: center;">
                    <p style="color: var(--text-muted);">The ledger is empty. History has no record of your intent.</p>
                    <br>
                    <code>./v verdict:decision</code>
                </div>
            @endforelse
        </div>
    </div>
@endsection