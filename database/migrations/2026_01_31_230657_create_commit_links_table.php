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
        Schema::create('commit_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decision_id')->constrained()->onDelete('cascade');
            $table->string('commit_hash')->unique();
            $table->string('author');
            $table->text('message');
            $table->timestamp('committed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commit_links');
    }
};
