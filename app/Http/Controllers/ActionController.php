<?php

namespace App\Http\Controllers;

use App\Models\Decision;
use App\Models\Outcome;
use App\Models\EnergyEvent;
use App\Models\User;
use App\Services\DecisionService;
use App\Services\GitService;
use App\Services\DriftService;
use App\Services\LedgerService;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function createDecision()
    {
        return view('create_decision');
    }

    public function storeDecision(Request $request, DecisionService $service)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'decision_type' => 'required|string',
            'confidence_level' => 'required|integer|min:0|max:100',
            'justification' => 'required|string',
            'known_unknowns' => 'nullable|string',
        ]);

        $user = User::firstOrCreate(['email' => 'admin@verdict.internal'], ['name' => 'Systems Architect']);

        $user = User::firstOrCreate(['email' => 'admin@verdict.internal'], ['name' => 'Systems Architect']);

        $service->create(
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'decision_type' => $data['decision_type'],
                'confidence_level' => $data['confidence_level'],
                'status' => 'open',
            ],
            [
                'known_unknowns' => array_filter(explode("\n", $data['known_unknowns'] ?? '')),
            ],
            $user->id,
            $data['justification']
        );

        // Link the user as an actor
        $decision = Decision::orderBy('id', 'desc')->first();
        $decision->actors()->create(['user_id' => $user->id, 'role' => 'architect']);

        return redirect()->route('timeline')->with('success', 'Decision committed to the immutable ledger.');
    }

    public function storeOutcome(Request $request, Decision $decision)
    {
        $data = $request->validate([
            'impact_type' => 'required|string',
            'severity' => 'required|integer|min:0|max:5',
            'measurable_delta' => 'required|string',
        ]);

        Outcome::create([
            'decision_id' => $decision->id,
            'impact_type' => $data['impact_type'],
            'severity' => $data['severity'],
            'measurable_delta' => $data['measurable_delta'],
        ]);

        return back()->with('success', 'Outcome recorded and linked to documented intent.');
    }

    public function recordEnergy(Request $request, Decision $decision)
    {
        $data = $request->validate([
            'energy_delta' => 'required|integer|min:-5|max:5',
            'notes' => 'nullable|string',
        ]);

        $user = User::firstOrCreate(['email' => 'admin@verdict.internal'], ['name' => 'Systems Architect']);

        EnergyEvent::create([
            'user_id' => $user->id,
            'decision_id' => $decision->id,
            'energy_delta' => $data['energy_delta'],
            'notes' => $data['notes'],
        ]);

        return back()->with('success', 'Human energy delta recorded.');
    }

    public function systemCockpit()
    {
        return view('system_actions');
    }

    public function syncGit(GitService $service)
    {
        $count = $service->sync();
        return back()->with('success', "Git synchronization complete. Linked {$count} new commits.");
    }

    public function runEnforce(DriftService $service)
    {
        $openDecisions = Decision::where('status', 'open')->get();
        $driftDetected = false;

        foreach ($openDecisions as $decision) {
            /** @var Decision $decision */
            if ($service->hasDrifted($decision)) {
                $driftDetected = true;
                break;
            }
        }

        if ($driftDetected) {
            return back()->with('error', 'Architectural DRIFT detected. Document your evolution.');
        }

        return back()->with('success', 'System integrity confirmed. No undocumented drift found.');
    }

    public function resolveDecision(Decision $decision, DecisionService $service)
    {
        $user = User::firstOrCreate(['email' => 'admin@verdict.internal'], ['name' => 'Systems Architect']);

        $service->transition($decision, 'resolved', $user->id, 'Resolved via UI Governance Cockpit.');

        return back()->with('success', 'Decision status transitioned to RESOLVED.');
    }

    public function runVerify(LedgerService $service)
    {
        if ($service->verifyChain()) {
            return back()->with('success', 'Ledger Integrity: COMPLIANT. History is untampered.');
        }

        return back()->with('error', 'Ledger Integrity: CORRUPTED. Immutable history compromised.');
    }
}
