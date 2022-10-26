<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('project_links', function (Blueprint $table) {
            $table->integer("project_id")->unsigned();
            $table->enum("type", ["steam_workshop", "git_repo", "website", "archive"]);
            $table->string("url");

            $table->primary(["project_id", "type"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_links');
    }
};
