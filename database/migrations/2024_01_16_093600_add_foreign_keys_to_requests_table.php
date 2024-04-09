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
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign(['user_id'])->references(['id'])->on('users');
            $table->foreign(['referer_url_id'])->references(['id'])->on('urls');
            $table->foreign(['user_agent_id'])->references(['id'])->on('user_agents');
            $table->foreign(['content_type_mime_type_id'])->references(['id'])->on('mime_types');
            $table->foreign(['origin_url_id'])->references(['id'])->on('urls');
            $table->foreign(['url_id'])->references(['id'])->on('urls');
            $table->foreign(['ip_adress_id'])->references(['id'])->on('ip_adresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_user_id_foreign');
            $table->dropForeign('requests_referer_url_id_foreign');
            $table->dropForeign('requests_user_agent_id_foreign');
            $table->dropForeign('requests_content_type_mime_type_id_foreign');
            $table->dropForeign('requests_origin_url_id_foreign');
            $table->dropForeign('requests_url_id_foreign');
            $table->dropForeign('requests_ip_adress_id_foreign');
        });
    }
};
