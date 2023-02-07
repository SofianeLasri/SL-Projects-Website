<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->integer("id", true, true);
            $table->string('name')->nullable();
            $table->string('filename')->unique();
            $table->string('path');
            $table->enum('type', ['image', 'video', 'audio', 'document', 'other']);
            $table->bigInteger('size');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_uploads');
    }
};
