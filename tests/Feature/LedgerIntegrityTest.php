<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Decision;
use App\Models\AccountabilityLedger;
use App\Services\DecisionService;
use App\Services\LedgerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LedgerIntegrityTest extends TestCase
{
    use RefreshDatabase;

    public function test_ledger_chains_correctly(): void
    {
        $ledgerService = new LedgerService();
        $decisionService = new DecisionService($ledgerService);

        $user = User::factory()->create();

        // 1. Create first decision
        $decision1 = $decisionService->create(
            ['title' => 'Decision 1', 'decision_type' => 'technical', 'confidence_level' => 80],
            ['metrics' => 'normal'],
            $user->id,
            'Initial setup'
        );

        // 2. Create second decision
        $decision2 = $decisionService->create(
            ['title' => 'Decision 2', 'decision_type' => 'product', 'confidence_level' => 90],
            ['metrics' => 'high'],
            $user->id,
            'Second step'
        );

        $ledgerEntries = AccountabilityLedger::orderBy('id', 'asc')->get();
        $this->assertCount(2, $ledgerEntries);

        // Check chaining
        $this->assertNull($ledgerEntries[0]->previous_hash);
        $this->assertEquals($ledgerEntries[0]->hash, $ledgerEntries[1]->previous_hash);

        // Verify chain integrity
        $this->assertTrue($ledgerService->verifyChain());
    }

    public function test_ledger_detects_tampering(): void
    {
        $ledgerService = new LedgerService();
        $decisionService = new DecisionService($ledgerService);
        $user = User::factory()->create();

        $decisionService->create(
            ['title' => 'Important Decision', 'decision_type' => 'technical'],
            ['risk' => 'low'],
            $user->id,
            'Legacy reasons'
        );

        $this->assertTrue($ledgerService->verifyChain());

        // Tamper with the ledger
        $entry = AccountabilityLedger::first();
        $entry->justification = 'I am changing history';
        $entry->save();

        // Chain should now be invalid
        $this->assertFalse($ledgerService->verifyChain());
    }
}
