<?php

namespace App\Console\Commands;

use App\Models\Outcome;
use App\Services\AutopsyService;
use Illuminate\Console\Command;

class AutopsyRun extends Command
{
    protected $signature = 'verdict:autopsy {outcome_id}';
    protected $description = 'Conduct a rule-based autopsy on an outcome';

    public function handle(AutopsyService $service)
    {
        $outcome = Outcome::findOrFail($this->argument('outcome_id'));
        $report = $service->conduct($outcome);

        $this->info('--- VERDICT AUTOPSY REPORT ---');
        $this->line("Outcome ID: {$report['outcome_id']}");
        $this->line("Verdict: " . ($report['verdict'] === 'FAILED' ? '<fg=red>FAILED</>' : '<fg=green>UNCLEAR</>'));

        if (empty($report['findings'])) {
            $this->info('No anomalies detected in the decision-o-sphere.');
        } else {
            foreach ($report['findings'] as $finding) {
                $this->warn("[{$finding['type']}] ({$finding['severity']}): {$finding['message']}");
            }
        }
    }
}
