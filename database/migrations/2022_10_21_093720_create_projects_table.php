<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->integer("id", true, true);
            $table->string("name");
            $table->string("slug");
            $table->string("route");
            $table->date("creation_date");
            $table->date("finished_date");
            $table->enum("status", ["finished", "abandoned", "paused"]);
            $table->enum("visibility", ["public", "private"]);

            $table->timestamps();

            $table->unique(["name", "slug", "route"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
