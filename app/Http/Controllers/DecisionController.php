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
        $decisions = Decision::with(['snapshot', 'outcomes'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('timeline', compact('decisions'));
    }

    public function show(Decision $decision, AutopsyService $autopsyService)
    {
        $decision->load(['snapshot', 'outcomes', 'actors', 'commitLinks', 'actors.user']);

        $autopsies = $decision->outcomes->map(function ($outcome) use ($autopsyService) {
            return $autopsyService->conduct($outcome);
        });

        return view('decision_detail', compact('decision', 'autopsies'));
    }

    public function verify(LedgerService $ledgerService)
    {
        $isValid = $ledgerService->verifyChain();
        $ledger = AccountabilityLedger::orderBy('id', 'desc')->take(50)->get();

        return view('ledger', compact('isValid', 'ledger'));
    }
}
