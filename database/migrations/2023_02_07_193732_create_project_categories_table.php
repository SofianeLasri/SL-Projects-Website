<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description');
            $table->enum('visibility', ['public', 'private']);
            $table->integer('logo_file_upload_id')->unsigned()->nullable();
            $table->integer('cover_file_upload_id')->unsigned()->nullable();

            $table->timestamps();

            $table->unique(['name', 'slug']);
            $table->foreign('logo_file_upload_id')->references('id')->on('file_uploads');
            $table->foreign('cover_file_upload_id')->references('id')->on('file_uploads');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_categories');
    }
};
