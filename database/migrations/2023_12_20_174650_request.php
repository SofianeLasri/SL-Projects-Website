<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'main';

    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('ip_adress_id')->references('id')->on('ip_adresses');

            $table->unsignedBigInteger('user_agent_id')->nullable();
            $table->foreign('user_agent_id')->references('id')->on('user_agents');

            $table->unsignedBigInteger('content_type_mime_type_id')->nullable();
            $table->foreign('content_type_mime_type_id')->references('id')->on('mime_types');
        });

        DB::table('requests')->get()->each(function ($request) {
            $userAgentId = null;
            if (! empty($request->user_agent)) {
                $userAgentId = DB::table('user_agents')->insertGetId(['value' => $request->user_agent]);
            }

            $mimeTypeId = null;
            if (! empty($request->content_type)) {
                $mimeTypeId = DB::table('mime_types')->insertGetId(['value' => $request->content_type]);
            }

            DB::table('requests')->where('id', $request->id)->update([
                'user_agent_id' => $userAgentId,
                'content_type_mime_type_id' => $mimeTypeId,
            ]);
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('user_agent');
            $table->dropColumn('content_type');
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('requests_ip_adress_id_foreign');
            $table->text('user_agent');
            $table->dropForeign(['user_agent_id']);
            $table->dropColumn('user_agent_id');
            $table->text('content_type');
            $table->dropForeign(['content_type_mime_type_id']);
            $table->dropColumn('content_type_mime_type_id');
        });
    }
};
