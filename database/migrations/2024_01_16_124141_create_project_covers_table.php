<?php

use App\Models\FileUpload;
use App\Models\Showcase\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {

        Schema::create('project_covers', function (Blueprint $table) {
            $mainConnectionDbName = config('database.connections.main.database');

            $table->id();
            $table->foreignIdFor(FileUpload::class)
                ->constrained(table: "$mainConnectionDbName.file_uploads")
                ->restrictOnDelete();
            $table->foreignIdFor(Project::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('ratio');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_covers');
    }
};
