@extends('layout')

@section('content')
    <div class="animate-fade">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('timeline') }}"
                style="color: var(--accent-toxic); text-decoration: none; font-size: 0.8rem; text-transform: uppercase;">&larr;
                Return to Timeline</a>
        </div>

        <div class="glass" style="padding: 3rem; margin-bottom: 3rem;">
            <div class="decision-meta">
                <span class="badge badge-{{ substr($decision->decision_type, 0, 4) }}">{{ $decision->decision_type }}</span>
                <span>ID: #{{ $decision->id }}</span>
                <span>CONFIDENCE: <strong
                        style="color: var(--accent-toxic)">{{ $decision->confidence_level }}%</strong></span>
            </div>

            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">{{ $decision->title }}</h1>
            <p style="font-size: 1.1rem; margin-bottom: 2rem;">{{ $decision->description }}</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <div class="glass" style="padding: 1.5rem; border-color: rgba(57, 255, 20, 0.2);">
                    <h3
                        style="color: var(--accent-toxic); margin-bottom: 1rem; font-size: 0.8rem; text-transform: uppercase;">
                        Context Snapshot</h3>
                    <pre
                        style="font-size: 0.8rem; color: var(--text-muted); background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 4px; overflow-x: auto;">{{ json_encode($decision->snapshot->data ?? [], JSON_PRETTY_PRINT) }}</pre>
                </div>

                <div class="glass" style="padding: 1.5rem; border-color: rgba(8, 247, 254, 0.2);">
                    <h3
                        style="color: var(--accent-cyber); margin-bottom: 1rem; font-size: 0.8rem; text-transform: uppercase;">
                        Actors & Intent</h3>
                    @foreach($decision->actors as $actor)
                        <div style="margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">
                            <div style="display: flex; justify-content: space-between;">
                                <strong>{{ $actor->user->name ?? 'Unknown Actor' }}</strong>
                                <span class="badge" style="border: 1px solid var(--text-muted);">{{ $actor->role }}</span>
                            </div>
                            @if($actor->objections)
                                <p style="color: var(--accent-crimson); font-size: 0.8rem; margin-top: 0.4rem;">OBJECTION:
                                    {{ $actor->objections }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if($decision->commitLinks->isNotEmpty())
        <h2 style="margin-bottom: 2rem; color: var(--accent-cyber);">CODE <span>EVIDENCE</span></h2>
        <div class="glass" style="padding: 1rem; margin-bottom: 3rem; background: rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse; font-family: monospace; font-size: 0.85rem;">
                @foreach($decision->commitLinks as $link)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 0.8rem; color: var(--accent-toxic);">{{ substr($link->commit_hash, 0, 7) }}</td>
                        <td style="padding: 0.8rem; color: var(--text-primary);">{{ $link->message }}</td>
                        <td style="padding: 0.8rem; color: var(--text-muted); text-align: right;">{{ $link->author }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endif

    @if($autopsies->isNotEmpty())
            <h2 style="margin-bottom: 2rem; color: var(--accent-crimson);">AUTOPSY <span>REPORTS</span></h2>
            @foreach($autopsies as $report)
                <div class="glass"
                    style="padding: 2rem; border-left: 4px solid {{ $report['verdict'] === 'FAILED' ? 'var(--accent-crimson)' : 'var(--accent-toxic)' }}; margin-bottom: 2rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="text-transform: uppercase; letter-spacing: 1px; font-weight: 800;">Verdict:
                            {{ $report['verdict'] }}</span>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $report['timestamp'] }}</span>
                    </div>

                    @foreach($report['findings'] as $finding)
                        <div style="margin-bottom: 1rem; padding: 1rem; background: rgba(255, 7, 58, 0.05); border-radius: 4px;">
                            <span style="font-weight: 700; color: var(--accent-crimson);">[{{ strtoupper($finding['type']) }}]</span>
                            {{ $finding['message'] }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
@endsection