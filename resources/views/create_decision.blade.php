@extends('layout')

@section('content')
    <div class="animate-fade" style="max-width: 800px; margin: 0 auto;">
        <h1 style="margin-bottom: 2rem; font-weight: 800;">COMMIT <span>INTENT</span></h1>

        <div class="glass" style="padding: 3rem;">
            <form action="{{ route('decisions.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 2rem;">
                    <label
                        style="display: block; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Title</label>
                    <input type="text" name="title" required
                        style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); padding: 1rem; color: #fff; border-radius: 4px; font-size: 1.1rem;"
                        placeholder="e.g., Fragmenting the monolith">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <label
                            style="display: block; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Decision
                            Type</label>
                        <select name="decision_type"
                            style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); padding: 1rem; color: #fff; border-radius: 4px;">
                            <option value="architectural">Architectural</option>
                            <option value="strategic">Strategic</option>
                            <option value="operational">Operational</option>
                            <option value="technical_debt">Technical Debt</option>
                        </select>
                    </div>
                    <div>
                        <label
                            style="display: block; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Confidence
                            Level (%)</label>
                        <input type="number" name="confidence_level" value="80" min="0" max="100"
                            style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); padding: 1rem; color: #fff; border-radius: 4px;">
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label
                        style="display: block; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Description</label>
                    <textarea name="description" required rows="3"
                        style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); padding: 1rem; color: #fff; border-radius: 4px; font-family: inherit;"></textarea>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label
                        style="display: block; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Justification
                        / Core Intent</label>
                    <textarea name="justification" required rows="3"
                        style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); padding: 1rem; color: #fff; border-radius: 4px; font-family: inherit;"
                        placeholder="Why this? Why now?"></textarea>
                </div>

                <div style="margin-bottom: 3rem;">
                    <label
                        style="display: block; font-size: 0.7rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem;">Known
                        Unknowns (One per line)</label>
                    <textarea name="known_unknowns" rows="3"
                        style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); padding: 1rem; color: #fff; border-radius: 4px; font-family: monospace;"
                        placeholder="What might we be missing?"></textarea>
                </div>

                <button type="submit" class="btn" style="width: 100%; padding: 1.5rem; font-size: 1rem;">COMMIT TO
                    LEDGER</button>
            </form>
        </div>
    </div>
@endsection