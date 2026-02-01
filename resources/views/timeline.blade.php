@extends('layout')

@section('content')
    <div class="animate-fade">
        <h1 style="margin-bottom: 2rem; font-weight: 800;">DECISION <span>TIMELINE</span></h1>

        <div class="timeline">
            @forelse($decisions as $decision)
                <div class="decision-card glass">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span
                            class="badge badge-{{ substr($decision->decision_type, 0, 4) }}">{{ $decision->decision_type }}</span>
                        @if($decision->energyEvents->isNotEmpty())
                            <span
                                style="font-size: 0.7rem; color: {{ $decision->energyEvents->sum('energy_delta') >= 0 ? 'var(--accent-toxic)' : 'var(--accent-crimson)' }}; letter-spacing: 1px;">
                                ENERGY:
                                {{ $decision->energyEvents->sum('energy_delta') > 0 ? '+' : '' }}{{ $decision->energyEvents->sum('energy_delta') }}
                            </span>
                        @endif
                    </div>
                    <div class="decision-meta" style="margin-bottom: 0.5rem;">
                        <span>CONFIDENCE: <strong
                                style="color: var(--accent-toxic)">{{ $decision->confidence_level }}%</strong></span>
                        <span>CREATED: {{ $decision->created_at->format('Y-m-d H:i') }}</span>
                        @if($decision->actors->isNotEmpty())
                            <span>BY: <a href="{{ route('actors.show', $decision->actors->first()->user_id) }}"
                                    style="color: var(--accent-cyber); text-decoration: none;">{{ $decision->actors->first()->user->name ?? 'System' }}</a></span>
                        @endif
                    </div>

                    <h2 style="margin-bottom: 0.5rem;"><a href="{{ route('decisions.show', $decision) }}"
                            style="color: inherit; text-decoration: none;">{{ $decision->title }}</a></h2>
                    <p style="color: var(--text-muted); margin-bottom: 1.5rem;">{{ Str::limit($decision->description, 150) }}
                    </p>

                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);">
                        @if($decision->actors->isNotEmpty())
                            <a href="{{ route('actors.show', $decision->actors->first()->user_id) }}"
                                style="display: flex; align-items: center; gap: 0.8rem; text-decoration: none; color: var(--text-primary); background: rgba(255,255,255,0.03); padding: 0.5rem 1rem; border-radius: 50px; border: 1px solid rgba(255,255,255,0.05);">
                                <div
                                    style="width: 28px; height: 28px; background: var(--accent-cyber); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #000; font-weight: 900;">
                                    {{ substr($decision->actors->first()->user->name ?? 'S', 0, 1) }}
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span
                                        style="font-size: 0.8rem; font-weight: 700;">{{ $decision->actors->first()->user->name ?? 'System' }}</span>
                                    <span style="font-size: 0.6rem; color: var(--accent-cyber); text-transform: uppercase;">View
                                        Full Record</span>
                                </div>
                            </a>
                        @endif
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