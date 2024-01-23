<?php

use App\Models\FileUpload;
use App\Models\Showcase\ProjectBuildingBlocFileUploadAssembly;
use App\Models\TranslationKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::create('pbb_fu_assemblies_ent', function (Blueprint $table) {
            $mainConnectionDbName = config('database.connections.main.database');

            $table->id();
            $table->foreignIdFor(ProjectBuildingBlocFileUploadAssembly::class, 'file_upload_assembly_id')
                ->constrained(table: 'pbb_fu_assemblies')
                ->restrictOnDelete();
            $table->integer('display_order');
            $table->foreignIdFor(FileUpload::class)
                ->constrained(table: "$mainConnectionDbName.file_uploads")
                ->cascadeOnDelete();
            $table->foreignIdFor(TranslationKey::class, 'name_translation_id')
                ->nullable()
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
            $table->foreignIdFor(TranslationKey::class, 'description_translation_id')
                ->nullable()
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_building_bloc_file_upload_assembly_entities');
    }
};
