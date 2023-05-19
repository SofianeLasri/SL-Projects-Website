<?php

use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('project_category_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->foreignIdFor(ProjectCategory::class);
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_category_pivots');
    }
};
