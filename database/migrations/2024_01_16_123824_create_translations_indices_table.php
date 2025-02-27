<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'main';

    public function up(): void
    {
        Schema::create('translations_indices', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations_indices');
    }
};
