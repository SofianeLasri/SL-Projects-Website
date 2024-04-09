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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ip_adress_id')->index('requests_ip_adress_id_foreign');
            $table->string('country_code')->nullable();
            $table->enum('method', ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'CONNECT', 'HEAD', 'OPTIONS', 'TRACE']);
            $table->integer('content_length')->nullable();
            $table->integer('status_code')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('requests_user_id_foreign');
            $table->timestamps();
            $table->unsignedBigInteger('user_agent_id')->nullable()->index('requests_user_agent_id_foreign');
            $table->unsignedBigInteger('content_type_mime_type_id')->nullable()->index('requests_content_type_mime_type_id_foreign');
            $table->unsignedBigInteger('url_id')->nullable()->index('requests_url_id_foreign');
            $table->unsignedBigInteger('referer_url_id')->nullable()->index('requests_referer_url_id_foreign');
            $table->unsignedBigInteger('origin_url_id')->nullable()->index('requests_origin_url_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
