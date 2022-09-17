<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('steam_user_profiles', function (Blueprint $table) {
            $table->bigInteger('steamid');
            $table->tinyInteger('communityvisibilitystate');
            $table->tinyInteger('profilestate');
            $table->string('personaname');
            $table->tinyInteger('commentpermission');
            $table->string('profileurl');
            $table->string('avatar');
            $table->string('avatarmedium');
            $table->string('avatarfull');
            $table->string("avatarhash");
            $table->unsignedInteger("lastlogoff");
            $table->tinyInteger("personastate");
            $table->string('realname');
            $table->bigInteger('primaryclanid');
            $table->unsignedInteger('timecreated');
            $table->tinyInteger("personastateflags");
            $table->char('loccountrycode', 2);
            $table->char('locstatecode', 2);

            $table->primary('steamid');
        });
    }

    public function down()
    {
        Schema::dropIfExists('steam_user_profiles');
    }
};
