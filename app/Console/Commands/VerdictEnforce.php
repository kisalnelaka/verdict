<?php

namespace App\Console\Commands;

use App\Models\Decision;
use App\Services\DriftService;
use Illuminate\Console\Command;

class VerdictEnforce extends Command
{
    protected $signature = 'verdict:enforce {--strict}';
    protected $description = 'Enforce architectural integrity and decision evidence';

    public function handle(DriftService $service)
    {
        $this->info('Scanning for architectural drift...');

        $openDecisions = Decision::where('status', 'open')->get();
        $driftDetected = false;

        foreach ($openDecisions as $decision) {
            /** @var Decision $decision */
            if ($service->hasDrifted($decision)) {
                $this->error("[DRIFT] System diverged from intent in decision #{$decision->id}: {$decision->title}");
                $driftDetected = true;
            }
        }

        if ($this->option('strict')) {
            foreach ($openDecisions as $decision) {
                /** @var Decision $decision */
                if ($decision->id > 0 && $decision->commitLinks()->count() === 0) {
                    $this->warn("[EVIDENCE MISSING] Decision #{$decision->id} has no linked commits.");
                }
            }
        }

        if ($driftDetected) {
            $this->error('Enforcement FAILED. Document your drift.');
            return 1;
        }

        $this->info('Enforcement passed. History is clean.');
        return 0;
    }
}
