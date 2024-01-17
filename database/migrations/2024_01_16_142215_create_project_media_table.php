<?php

use App\Models\FileUpload;
use App\Models\Showcase\Project;
use App\Models\TranslationKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::create('project_media', function (Blueprint $table) {
            $mainConnectionDbName = config('database.connections.main.database');

            $table->id();
            $table->foreignIdFor(Project::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('display_order');
            $table->enum('type', ['fileupload', 'link']);
            $table->foreignIdFor(FileUpload::class)
                ->nullable()
                ->constrained(table: "$mainConnectionDbName.file_uploads")
                ->cascadeOnDelete();
            $table->string('link')->nullable();
            $table->foreignIdFor(TranslationKey::class, 'name_translation_index')
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_media');
    }
};
