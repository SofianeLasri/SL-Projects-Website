<?php

use App\Models\FileUpload;
use App\Models\Showcase\ProjectDraft;
use App\Models\TranslationKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::create('project_draft_media', function (Blueprint $table) {
            $mainConnectionDbName = config('database.connections.main.database');

            $table->id();
            $table->foreignIdFor(ProjectDraft::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedInteger('display_order');
            $table->enum('type', ['fileupload', 'link']);
            $table->foreignIdFor(FileUpload::class)
                ->nullable()
                ->constrained(table: "$mainConnectionDbName.file_uploads")
                ->restrictOnDelete();
            $table->string('link')->nullable();
            $table->foreignIdFor(TranslationKey::class, 'name_translation_id')
                ->nullable()
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_draft_media');
    }
};
