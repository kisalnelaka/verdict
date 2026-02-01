@extends('layout')

@section('content')
    <div class="animate-fade">
        <h1 style="margin-bottom: 2rem; font-weight: 800;">SYSTEM <span>COCKPIT</span></h1>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div class="glass" style="padding: 2.5rem;">
                <h2 style="color: var(--accent-toxic); margin-bottom: 1rem;">Git Synchronization</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Scans the repository history
                    for <code>[D#]</code> tags and links implementation evidence to documented intent.</p>

                <form action="{{ route('system.sync') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn" style="width: 100%;">RUN SYNCHRONIZATION</button>
                </form>
            </div>

            <div class="glass" style="padding: 2.5rem;">
                <h2 style="color: var(--accent-cyber); margin-bottom: 1rem;">Architectural Enforcement</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Verifies current repository
                    state against historical snapshots. Flags undocumented structural evolution.</p>

                <form action="{{ route('system.enforce') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn"
                        style="width: 100%; border-color: var(--accent-cyber); color: var(--accent-cyber);">RUN ENFORCEMENT
                        ENGINE</button>
                </form>
            </div>
        </div>

        <div class="glass" style="margin-top: 2rem; padding: 2.5rem; border-color: var(--accent-toxic);">
            <h2 style="color: var(--accent-toxic); margin-bottom: 1rem;">Ledger Verification</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Validates the SHA-256 hash chain of
                the accountability ledger. Detects any manipulation of the immutable history.</p>

            <form action="{{ route('system.verify') }}" method="POST">
                @csrf
                <button type="submit" class="btn"
                    style="width: 100%; border-color: var(--accent-toxic); color: var(--accent-toxic);">VERIFY
                    INTEGRITY</button>
            </form>
        </div>

        <div class="glass"
            style="margin-top: 3rem; padding: 2rem; border-color: rgba(255, 7, 58, 0.2); background: rgba(255, 7, 58, 0.05);">
            <h3 style="color: var(--accent-crimson); margin-bottom: 0.5rem; font-size: 0.8rem; text-transform: uppercase;">
                Infrastructure Status</h3>
            <div style="display: flex; gap: 2rem; font-family: monospace; font-size: 0.75rem;">
                <div>PHP Version: <span style="color: #fff;">{{ phpversion() }}</span></div>
                <div>Ledger State: <span style="color: var(--accent-toxic);">IMMUTABLE</span></div>
                <div>Cognitive Density: <span style="color: var(--accent-cyber);">HIGH</span></div>
            </div>
        </div>
    </div>
@endsection