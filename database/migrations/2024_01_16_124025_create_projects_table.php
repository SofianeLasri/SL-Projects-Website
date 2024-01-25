<?php

use App\Models\TranslationKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $mainConnectionDbName = config('database.connections.main.database');

            $table->id();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignIdFor(TranslationKey::class, 'content_translation_id')
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
            $table->enum('release_status', ['running', 'finished', 'cancelled'])->default('running');
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
