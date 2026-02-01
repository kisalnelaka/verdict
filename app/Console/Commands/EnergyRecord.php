<?php

namespace App\Console\Commands;

use App\Models\Decision;
use App\Models\EnergyEvent;
use App\Models\User;
use Illuminate\Console\Command;

class EnergyRecord extends Command
{
    protected $signature = 'verdict:energy {decision_id}';
    protected $description = 'Record the human energy impact of a decision';

    public function handle()
    {
        $decision = Decision::findOrFail($this->argument('decision_id'));

        $email = $this->ask('Identification (email)');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('Unknown actor. Identity is required for accountability.');
            return 1;
        }

        $delta = $this->choice('Energy Delta (Effect on team spirit/vitality)', [
            '-5' => 'Catastrophic Burnout',
            '-2' => 'Significant Drain',
            '0' => 'Neutral/Sustainable',
            '2' => 'Inspirational/Energizing',
            '5' => 'Transcendental Flow',
        ], '0');

        $notes = $this->ask('Contextual notes (optional)');

        EnergyEvent::create([
            'user_id' => $user->id,
            'decision_id' => $decision->id,
            'energy_delta' => (int) $delta,
            'notes' => $notes,
        ]);

        $this->info('Energy event recorded. The ledger remembers your sacrifice.');
        return 0;
    }
}
