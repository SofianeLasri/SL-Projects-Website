<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = 'main';

    public function up(): void
    {
        Schema::create('ip_adresses', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_adresses');
    }
};