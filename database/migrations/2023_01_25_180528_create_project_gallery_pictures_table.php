<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('project_gallery_pictures', function (Blueprint $table) {
            $table->integer("id", true, true);
            $table->integer("project_id");
            $table->integer("file_upload_id");

            $table->timestamps();

            $table->foreign("project_id")->references("id")->on("projects");
            $table->foreign("file_upload_id")->references("id")->on("file_uploads");
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_gallery_pictures');
    }
};