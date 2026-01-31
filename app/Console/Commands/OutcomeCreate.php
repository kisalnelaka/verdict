<?php

namespace App\Console\Commands;

use App\Models\Decision;
use App\Models\Outcome;
use Illuminate\Console\Command;

class OutcomeCreate extends Command
{
    protected $signature = 'verdict:outcome {decision_id}';
    protected $description = 'Record an outcome for a decision';

    public function handle()
    {
        $decision = Decision::findOrFail($this->argument('decision_id'));

        $type = $this->choice('Impact Type', ['incident', 'performance', 'delay', 'cost', 'rework'], 0);
        $severity = $this->ask('Severity (1-5)', 1);
        $delta = $this->ask('Measurable Delta (e.g. 5000 for cost or 20 for delay hours)', 0);

        $outcome = Outcome::create([
            'decision_id' => $decision->id,
            'impact_type' => $type,
            'severity' => (int) $severity,
            'measurable_delta' => (float) $delta,
            'occurred_at' => now(),
        ]);

        $this->info("Outcome recorded. ID: {$outcome->id}. Use 'verdict:autopsy {$outcome->id}' to analyze.");
    }
}
