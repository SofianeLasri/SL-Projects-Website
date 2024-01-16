<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'main';

    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('index');
            $table->enum('country_code', ['FR', 'EN']);
            $table->text('message');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
