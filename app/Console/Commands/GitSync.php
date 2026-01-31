<?php

namespace App\Console\Commands;

use App\Services\GitService;
use Illuminate\Console\Command;

class GitSync extends Command
{
    protected $signature = 'verdict:sync-git';
    protected $description = 'Scan git log for decision links [D#]';

    public function handle(GitService $service)
    {
        $this->info('Scanning git log for evidence of intent...');

        $count = $service->sync();

        if ($count > 0) {
            $this->info("Linked {$count} new commits to the ledger.");
        } else {
            $this->comment('No new linked commits found. Intent and implementation are either synchronized or disconnected.');
        }
    }
}
