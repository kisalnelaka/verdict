<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\DecisionService;
use App\Services\LedgerService;
use App\Models\Outcome;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $ledgerService = new LedgerService();
        $decisionService = new DecisionService($ledgerService);

        $user = User::firstOrCreate(['email' => 'admin@verdict.internal'], [
            'name' => 'Systems Architect',
            'password' => bcrypt('bunta123'),
        ]);

        // Decision 1: Success
        $decision1 = $decisionService->create(
            [
                'title' => 'Migration to Micro-Cognitive Services',
                'description' => 'Moving the legacy monolithic governance engine to a distributed cognitive model.',
                'decision_type' => 'architectural',
                'confidence_level' => 85,
                'status' => 'resolved',
            ],
            ['known_unknowns' => ['latency overhead'], 'known_risks' => ['network partitions']],
            $user->id,
            'Required for scaling the autopsy engine across regional clusters.'
        );

        Outcome::create([
            'decision_id' => $decision1->id,
            'impact_type' => 'performance',
            'severity' => 2,
            'measurable_delta' => 12.5,
            'occurred_at' => now()->subDays(2),
        ]);

        // Decision 2: Failure (for Autopsy Demo)
        $decision2 = $decisionService->create(
            [
                'title' => 'Bypass Ledger for Emergency Patch',
                'description' => 'Disabling the accountability ledger to push a critical fix for the database connection pool.',
                'decision_type' => 'operational',
                'confidence_level' => 95,
                'status' => 'resolved',
            ],
            ['known_unknowns' => [], 'known_risks' => ['loss of memory']],
            $user->id,
            'Fix the 500 errors immediately at all costs.'
        );

        Outcome::create([
            'decision_id' => $decision2->id,
            'impact_type' => 'incident',
            'severity' => 5,
            'measurable_delta' => 0,
            'occurred_at' => now()->subDay(),
        ]);
    }
}
