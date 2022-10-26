<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('project_category_pivots', function (Blueprint $table) {
            $table->integer("project_id")->unsigned();
            $table->integer("category_id")->unsigned();

            $table->primary(["project_id", "category_id"]);

            $table->foreign("project_id")->references("id")->on("projects");
            $table->foreign("category_id")->references("id")->on("project_categories");
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_category_pivots');
    }
};
