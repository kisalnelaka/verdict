<?php

namespace App\Console\Commands;

use App\Services\LedgerService;
use Illuminate\Console\Command;

class VerdictVerify extends Command
{
    protected $signature = 'verdict:verify';
    protected $description = 'Verify the integrity of the Accountability Ledger';

    public function handle(LedgerService $service)
    {
        $this->info('Verifying immutable memory...');

        if ($service->verifyChain()) {
            $this->info('Ledger integrity: <fg=green>VALID</>');
            $this->line('History is frozen and correct.');
        } else {
            $this->error('Ledger integrity: CORRUPTED');
            $this->error('History has been tampered with. Cognitive infrastructure compromised.');
        }
    }
}
