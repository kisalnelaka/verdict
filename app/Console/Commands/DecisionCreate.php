<?php

namespace App\Console\Commands;

use App\Services\DecisionService;
use App\Models\User;
use Illuminate\Console\Command;

class DecisionCreate extends Command
{
    protected $signature = 'verdict:decision';
    protected $description = 'Create a new first-class Decision';

    public function handle(DecisionService $service)
    {
        $this->info('--- NEW VERDICT DECISION ---');

        $title = $this->ask('Title (be professional, or don\'t)');
        $description = $this->ask('Description');
        $type = $this->choice('Type', ['technical', 'product', 'operational', 'architectural'], 0);
        $confidence = $this->ask('Confidence Level (0-100)', 50);

        $unknowns = $this->ask('Known Unknowns (comma separated)', '');
        $risks = $this->ask('Known Risks (comma separated)', '');

        $justification = $this->ask('Justify your existence (Justification for this decision)');

        $user = User::firstOrCreate(['email' => 'admin@verdict.internal'], [
            'name' => 'Systems Architect',
            'password' => bcrypt('bunta123'),
        ]);

        $decision = $service->create(
            [
                'title' => $title,
                'description' => $description,
                'decision_type' => $type,
                'confidence_level' => (int) $confidence,
                'status' => 'open',
            ],
            [
                'known_unknowns' => explode(',', $unknowns),
                'known_risks' => explode(',', $risks),
                'human_energy' => 'stable', // Phase 1 default
            ],
            $user->id,
            $justification
        );

        $this->info("Decision recorded in the ledger. ID: {$decision->id}");
    }
}
