<?php

use App\Models\Showcase\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::create('project_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('content_translation_id');
            $table->string('release_status');
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_drafts');
    }
};
