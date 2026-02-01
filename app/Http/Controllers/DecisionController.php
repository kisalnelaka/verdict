<?php

namespace App\Http\Controllers;

use App\Models\Decision;
use App\Models\Outcome;
use App\Models\AccountabilityLedger;
use App\Services\AutopsyService;
use App\Services\LedgerService;
use Illuminate\Http\Request;

class DecisionController extends Controller
{
    public function index()
    {
        $decisions = Decision::with(['snapshot', 'outcomes', 'actors', 'actors.user', 'energyEvents'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('timeline', compact('decisions'));
    }

    public function show(
        Decision $decision,
        AutopsyService $autopsyService,
        \App\Services\ResonanceService $resonanceService,
        \App\Services\WisdomService $wisdomService
    ) {
        $decision->load(['snapshot', 'outcomes', 'actors', 'commitLinks', 'actors.user', 'energyEvents']);

        $autopsies = $decision->outcomes->map(function ($outcome) use ($autopsyService) {
            return $autopsyService->conduct($outcome);
        });

        $resonance = $resonanceService->calculateResonance($decision);

        // Enrich actors with wisdom index
        $decision->actors->each(function ($actor) use ($wisdomService) {
            if ($actor->user) {
                $actor->user->wisdom_index = $wisdomService->getWisdomIndex($actor->user);
            }
        });

        return view('decision_detail', compact('decision', 'autopsies', 'resonance'));
    }

    public function verify(LedgerService $ledgerService)
    {
        $isValid = $ledgerService->verifyChain();
        $ledger = AccountabilityLedger::orderBy('id', 'desc')->take(50)->get();

        return view('ledger', compact('isValid', 'ledger'));
    }

    public function actorShow(\App\Models\User $user, \App\Services\WisdomService $wisdomService)
    {
        $wisdomIndex = $wisdomService->getWisdomIndex($user);
        $decisions = Decision::whereHas('actors', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('outcomes')->orderBy('created_at', 'desc')->get();

        return view('actor_profile', compact('user', 'wisdomIndex', 'decisions'));
    }
}
