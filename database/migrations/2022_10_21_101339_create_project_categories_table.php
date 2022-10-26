<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->integer("id", true, true);
            $table->integer("parentId")->unsigned();
            $table->string("name");
            $table->string("slug");
            $table->timestamps();

            $table->foreign("parentId")->references("id")->on("project_categories");
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_categories');
    }
};
