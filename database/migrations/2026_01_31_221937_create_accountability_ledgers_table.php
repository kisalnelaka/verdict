<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('accountability_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type')->nullable(); // Decision, Outcome, etc.
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('action'); // created, approved, overridden, risk_accepted
            $table->foreignId('actor_id')->nullable()->constrained('users');
            $table->text('justification');
            $table->string('hash', 64)->unique();
            $table->string('previous_hash', 64)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['entity_type', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountability_ledgers');
    }
};
