@extends('layout')

@section('content')
    <div class="animate-fade">
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('timeline') }}"
                style="color: var(--accent-toxic); text-decoration: none; font-size: 0.8rem; text-transform: uppercase;">&larr;
                Return to Timeline</a>
        </div>

        <div
            style="text-align: center; margin-bottom: 4rem; padding-bottom: 3rem; border-bottom: 1px solid var(--glass-border);">
            <div class="decision-meta" style="justify-content: center; margin-bottom: 2rem;">
                <span class="badge badge-{{ substr($decision->decision_type, 0, 4) }}">{{ $decision->decision_type }}</span>
                <span class="monospace">ID: #{{ $decision->id }}</span>
                <span>CONFIDENCE: <strong
                        style="color: var(--accent-toxic)">{{ $decision->confidence_level }}%</strong></span>
            </div>

            <h1 style="font-size: 3.5rem; margin-bottom: 1.5rem; line-height: 1.1;">{{ $decision->title }}</h1>
            <p style="font-size: 1.3rem; color: var(--text-muted); max-width: 800px; margin: 0 auto;">
                {{ $decision->description }}</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div class="glass" style="padding: 1.5rem; border-color: rgba(57, 255, 20, 0.2);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <h3 style="color: var(--accent-toxic); font-size: 0.8rem; text-transform: uppercase;">Cognitive
                        Impact</h3>
                    <span class="badge" style="border-color: var(--accent-cyber); color: var(--accent-cyber);">RESONANCE:
                        {{ $resonance['status'] }}</span>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 0.4rem;">
                        <span>HUMAN ENERGY DELTA</span>
                        <span
                            style="color: {{ $decision->energyEvents->sum('energy_delta') >= 0 ? 'var(--accent-toxic)' : 'var(--accent-crimson)' }}">
                            {{ $decision->energyEvents->sum('energy_delta') > 0 ? '+' : '' }}{{ $decision->energyEvents->sum('energy_delta') }}
                        </span>
                    </div>
                    <div
                        style="height: 4px; background: rgba(255,255,255,0.05); border-radius: 2px; overflow: hidden; margin-bottom: 1rem;">
                        <div
                            style="height: 100%; background: {{ $decision->energyEvents->sum('energy_delta') >= 0 ? 'var(--accent-toxic)' : 'var(--accent-crimson)' }}; width: {{ min(100, abs($decision->energyEvents->sum('energy_delta') * 10)) }}%">
                        </div>
                    </div>

                    <form action="{{ route('decisions.energy', $decision) }}" method="POST"
                        style="display: flex; gap: 0.5rem; align-items: center;">
                        @csrf
                        <select name="energy_delta"
                            style="background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); color: #fff; font-size: 0.7rem; padding: 0.3rem;">
                            <option value="-5">-5 (Burnout)</option>
                            <option value="-2">-2 (Drain)</option>
                            <option value="0" selected>0 (Sustainable)</option>
                            <option value="2">+2 (Energizing)</option>
                            <option value="5">+5 (Flow)</option>
                        </select>
                        <button type="submit" class="btn" style="padding: 0.3rem 0.6rem; font-size: 0.6rem;">Log
                            Energy</button>
                    </form>
                </div>

                <pre
                    style="font-size: 0.8rem; color: var(--text-muted); background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 4px; overflow-x: auto;">{{ json_encode($decision->snapshot->data ?? [], JSON_PRETTY_PRINT) }}</pre>
            </div>

            <div class="glass" style="padding: 1.5rem; border-color: rgba(8, 247, 254, 0.2);">
                <h3 style="color: var(--accent-cyber); margin-bottom: 1rem; font-size: 0.8rem; text-transform: uppercase;">
                    Actors & Intent</h3>
                @foreach($decision->actors as $actor)
                    <div style="margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <strong style="display: block;"><a href="{{ route('actors.show', $actor->user_id) }}"
                                        style="color: inherit; text-decoration: none; border-bottom: 1px dashed var(--accent-cyber);">{{ $actor->user->name ?? 'Unknown Actor' }}</a></strong>
                                <span style="font-size: 0.7rem; color: var(--text-muted);">WISDOM INDEX: <strong
                                        style="color: var(--accent-cyber)">{{ $actor->user->wisdom_index ?? 50 }}</strong></span>
                            </div>
                            <span class="badge" style="border: 1px solid var(--text-muted);">{{ $actor->role }}</span>
                        </div>
                        @if($actor->objections)
                            <p style="color: var(--accent-crimson); font-size: 0.8rem; margin-top: 0.4rem;">OBJECTION:
                                {{ $actor->objections }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if($decision->commitLinks->isNotEmpty())
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="color: var(--accent-cyber); margin: 0;">CODE <span>EVIDENCE</span></h2>

            <div class="glass" style="padding: 1rem; border-color: var(--accent-crimson);">
                <h4
                    style="font-size: 0.7rem; color: var(--accent-crimson); text-transform: uppercase; margin-bottom: 1rem; margin-top: 0;">
                    Record Outcome</h4>
                <form action="{{ route('decisions.outcomes', $decision) }}" method="POST"
                    style="display: flex; gap: 1rem; align-items: flex-end;">
                    @csrf
                    <div>
                        <label
                            style="display: block; font-size: 0.6rem; color: var(--text-muted); margin-bottom: 0.3rem;">IMPACT
                            TYPE</label>
                        <select name="impact_type"
                            style="background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); color: #fff; font-size: 0.7rem; padding: 0.4rem;">
                            <option value="incident">Incident</option>
                            <option value="success">Success</option>
                            <option value="delay">Delay</option>
                            <option value="cost">Cost</option>
                        </select>
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 0.6rem; color: var(--text-muted); margin-bottom: 0.3rem;">SEVERITY
                            (0-5)</label>
                        <input type="number" name="severity" value="0" min="0" max="5"
                            style="width: 50px; background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); color: #fff; font-size: 0.7rem; padding: 0.4rem;">
                    </div>
                    <div style="flex-grow: 1;">
                        <label
                            style="display: block; font-size: 0.6rem; color: var(--text-muted); margin-bottom: 0.3rem;">MEASURABLE
                            DELTA</label>
                        <input type="text" name="measurable_delta" required
                            style="width: 100%; background: rgba(0,0,0,0.5); border: 1px solid var(--glass-border); color: #fff; font-size: 0.7rem; padding: 0.4rem;"
                            placeholder="e.g., 2h downtime">
                    </div>
                    <button type="submit" class="btn" style="padding: 0.4rem 1rem; font-size: 0.7rem;">Record</button>
                </form>
            </div>
        </div>

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