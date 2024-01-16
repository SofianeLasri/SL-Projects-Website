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
        Schema::create('projects_building_blocs_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order');
            $table->foreignIdFor(Project::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects_building_blocs_groups');
    }
};
