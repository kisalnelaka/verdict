<?php

namespace App\Services;

use App\Models\Decision;
use App\Models\CommitLink;
use Illuminate\Support\Facades\Process;

class GitService
{
    /**
     * Scan git history for decision links.
     */
    public function sync(): int
    {
        $pattern = '/\[D([0-9]+)\]/';
        // Get commits from the last 100 entries
        $result = Process::run('git log -n 100 --pretty=format:"%H|%an|%ad|%s" --date=iso');

        if ($result->failed()) {
            return 0;
        }

        $lines = explode("\n", $result->output());
        $count = 0;

        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) < 4)
                continue;

            [$hash, $author, $date, $message] = $parts;

            if (preg_match($pattern, $message, $matches)) {
                $decisionId = $matches[1];

                if (Decision::where('id', $decisionId)->exists()) {
                    $link = CommitLink::firstOrCreate(
                        ['commit_hash' => $hash],
                        [
                            'decision_id' => $decisionId,
                            'author' => $author,
                            'message' => $message,
                            'committed_at' => $date,
                        ]
                    );

                    if ($link->wasRecentlyCreated) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }
}
