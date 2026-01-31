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
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(base_path(), \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $files = [];
        $excludes = ['.git', 'vendor', 'storage', 'node_modules', '.agent', 'brain'];

        foreach ($iterator as $file) {
            $path = $file->getRelativePathname();

            // Filter out excludes
            foreach ($excludes as $exclude) {
                if (str_starts_with($path, $exclude))
                    continue 2;
            }

            // We hash path and modification time for a "cheap" drift detection
            $files[] = $path . $file->getMTime();
        }

        sort($files);
        return hash('sha256', implode('|', $files));
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
