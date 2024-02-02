<?php

use App\Models\FileUpload;
use App\Models\TranslationKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('display_order');
            $table->foreignIdFor(FileUpload::class)
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(TranslationKey::class, 'name_translation_id')
                ->nullable()
                ->constrained(table: 'translations_indices')
                ->restrictOnDelete();
            $table->foreignIdFor(TranslationKey::class, 'description_translation_id')
                ->nullable()
                ->constrained(table: 'translations_indices')
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
}
