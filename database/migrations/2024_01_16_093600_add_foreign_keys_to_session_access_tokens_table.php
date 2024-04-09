<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'main';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('session_access_tokens', function (Blueprint $table) {
            $table->foreign(['session_id'])->references(['id'])->on('sessions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('session_access_tokens', function (Blueprint $table) {
            $table->dropForeign('session_access_tokens_session_id_foreign');
        });
    }
};
