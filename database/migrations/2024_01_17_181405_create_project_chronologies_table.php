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
        Schema::create('projects_chronology', function (Blueprint $table) {
            $mainConnectionDbName = config('database.connections.main.database');

            $table->id();
            $table->date('date');
            $table->foreignIdFor(TranslationKey::class, 'name_translation_id')
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
            $table->foreignIdFor(TranslationKey::class, 'description_translation_id')
                ->constrained(table: "$mainConnectionDbName.translations_indices")
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_chronologies');
    }
};
