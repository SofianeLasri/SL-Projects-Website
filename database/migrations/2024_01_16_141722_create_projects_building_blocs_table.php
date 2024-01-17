<?php

use App\Models\FileUpload;
use App\Models\Showcase\ProjectBuildingBlocGroup;
use App\Models\TranslationKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::create('projects_building_blocs', function (Blueprint $table) {
            $mainConnectionDbName = config('database.connections.main.database');

            $table->id();
            $table->foreignIdFor(ProjectBuildingBlocGroup::class, 'group_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('type', ['text', 'fileupload', 'youtube']);
            $table->string('translation_index')->nullable();
            $table->foreignIdFor(TranslationKey::class, 'translation_index')
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
            $table->foreignIdFor(FileUpload::class)
                ->nullable()
                ->constrained(table: "$mainConnectionDbName.file_uploads")
                ->cascadeOnDelete();
            $table->string('youtube_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects_building_blocs');
    }
};
