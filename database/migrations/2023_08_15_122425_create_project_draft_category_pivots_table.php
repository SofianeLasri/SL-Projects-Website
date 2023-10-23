<?php

use App\Models\Showcase\ProjectCategory;
use App\Models\Showcase\ProjectDraft;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDraftCategoryPivotsTable extends Migration
{
    protected $connection = 'showcase';
    public function up(): void
    {
        Schema::create('project_draft_category_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProjectDraft::class);
            $table->foreignIdFor(ProjectCategory::class);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_draft_category_pivots');
    }
}
