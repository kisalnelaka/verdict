@extends('layout')

@section('content')
    <div class="animate-fade">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
            <h1 style="font-weight: 800;">ACCOUNTABILITY <span>LEDGER</span></h1>
            <div class="glass"
                style="padding: 0.5rem 1.5rem; border-color: {{ $isValid ? 'var(--accent-toxic)' : 'var(--accent-crimson)' }};">
                STATUS: <strong
                    style="color: {{ $isValid ? 'var(--accent-toxic)' : 'var(--accent-crimson)' }}">{{ $isValid ? 'VERIFIED' : 'COMPROMISED' }}</strong>
            </div>
        </div>

        <div class="glass" style="padding: 1rem; background: rgba(0,0,0,0.2);">
            <table style="width: 100%; border-collapse: collapse; font-family: monospace; font-size: 0.85rem;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid var(--glass-border);">
                        <th style="padding: 1rem;">TIMESTAMP</th>
                        <th style="padding: 1rem;">ACTION</th>
                        <th style="padding: 1rem;">ENTITY</th>
                        <th style="padding: 1rem;">HASH</th>
                        <th style="padding: 1rem;">PREV_HASH</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ledger as $entry)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;"
                            onmouseover="this.style.background='rgba(57, 255, 20, 0.05)'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem; color: var(--text-muted);">{{ $entry->created_at }}</td>
                            <td style="padding: 1rem;"><span style="color: var(--accent-cyber)">{{ $entry->action }}</span></td>
                            <td style="padding: 1rem;">{{ basename($entry->entity_type) }} #{{ $entry->entity_id }}</td>
                            <td style="padding: 1rem; color: var(--accent-toxic);">{{ substr($entry->hash, 0, 8) }}...</td>
                            <td style="padding: 1rem; color: var(--text-muted);">{{ substr($entry->previous_hash, 0, 8) }}...
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection