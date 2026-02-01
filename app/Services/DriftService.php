<?php

namespace App\Services;

use App\Models\Decision;

class DriftService
{
    /**
     * Calculate structural hash of the codebase.
     */
    public function calculateStateHash(): string
    {
        $finder = new \Symfony\Component\Finder\Finder();
        $finder->files()
            ->in(base_path())
            ->exclude(['.git', 'vendor', 'storage', 'node_modules', '.agent', 'brain'])
            ->sortByName();

        $hashBasis = [];
        foreach ($finder as $file) {
            $hashBasis[] = $file->getRelativePathname() . $file->getMTime();
        }

        return hash('sha256', implode('|', $hashBasis));
    }

    /**
     * Check if the system has drifted away from a decision's snapshot.
     */
    public function hasDrifted(Decision $decision): bool
    {
        $snapshot = $decision->snapshot;
        if (!$snapshot || !$snapshot->architectural_state_hash) {
            return false;
        }

        return $this->calculateStateHash() !== $snapshot->architectural_state_hash;
    }
}
