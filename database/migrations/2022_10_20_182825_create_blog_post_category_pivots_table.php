<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('blog_post_category_pivots', function (Blueprint $table) {
            $table->integer("blog_post_id")->unsigned();
            $table->integer("category_id")->unsigned();

            $table->primary(["blog_post_id", "category_id"]);

            $table->foreign("blog_post_id")->references("id")->on("blog_posts");
            $table->foreign("category_id")->references("id")->on("blog_categories");
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_post_categories');
    }
};
