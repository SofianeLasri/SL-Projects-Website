<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->unsignedInteger("id",);
            $table->enum("type", ["draft", "published-article"]);
            $table->unsignedInteger("views");
            $table->string("slug");
            $table->text("title");
            $table->text("description");
            $table->text("content");
            $table->timestamps();

            $table->primary(["id", "type", "slug"]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
};
