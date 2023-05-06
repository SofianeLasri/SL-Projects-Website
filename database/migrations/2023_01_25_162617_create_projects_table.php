<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::connection('showcase')->create('projects', function (Blueprint $table) {
            $mainDbName = DB::connection('main')->getDatabaseName();
            $table->integer("id", true, true);
            $table->string("name");
            $table->string("slug");
            $table->text("description");
            $table->date("project_start_date");
            $table->date("project_end_date")->nullable();
            $table->enum("status", ["finished", "abandoned", "paused"]);
            $table->enum("visibility", ["public", "private"]);
            $table->integer("logo_file_upload_id")->unsigned()->nullable();
            $table->integer("cover_file_upload_id")->unsigned()->nullable();

            $table->timestamps();

            $table->unique(["name", "slug"]);
            $table->foreign("logo_file_upload_id")->references("id")->on("$mainDbName.file_uploads");
            $table->foreign("cover_file_upload_id")->references("id")->on("$mainDbName.file_uploads");
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
