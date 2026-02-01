<?php

namespace App\Services;

use App\Models\User;
use App\Models\Decision;
use App\Models\Outcome;

class WisdomService
{
    /**
     * Calculate the Wisdom Index for a user (Actor).
     */
    public function getWisdomIndex(User $user): float
    {
        $decisions = Decision::whereHas('actors', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('outcomes')->get();

        if ($decisions->isEmpty()) {
            return 0.0;
        }

        $totalDecisions = $decisions->count();
        $totalSeverity = 0;
        $successCount = 0;

        foreach ($decisions as $decision) {
            $severity = $decision->outcomes->sum('severity');
            $totalSeverity += $severity;

            if ($severity == 0 && $decision->status === 'resolved') {
                $successCount++;
            }
        }

        // Formula: (Successes * 10) - Total Severity / Total Decisions
        $score = (($successCount * 10) - $totalSeverity) / $totalDecisions;

        return round(max(0, min(100, $score + 50)), 2); // Normalized to 0-100, starting at 50
    }
}
