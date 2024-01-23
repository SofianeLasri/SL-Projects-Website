<?php

use App\Models\Showcase\ProjectBuildingBlocFileUploadAssembly;
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
                ->constrained(table: 'projects_building_blocs_groups')
                ->cascadeOnDelete();
            $table->enum('type', ['text', 'fileupload_assembly', 'youtube']);
            $table->foreignIdFor(TranslationKey::class, 'translation_id')
                ->nullable()
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
            $table->foreignIdFor(ProjectBuildingBlocFileUploadAssembly::class, 'file_upload_assembly_id')
                ->nullable()
                ->constrained(table: 'pbb_fu_assemblies')
                ->restrictOnDelete();
            $table->string('youtube_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects_building_blocs');
    }
};
