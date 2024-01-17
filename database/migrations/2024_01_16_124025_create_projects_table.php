<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('name');
            $table->string('slug')->unique();
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
