<?php

use App\Models\MimeType;
use App\Models\UserAgent;
use App\Models\Url as UrlModel;
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

            $table->unsignedBigInteger('url_id')->nullable();
            $table->foreign('url_id')->references('id')->on('urls');

            $table->unsignedBigInteger('referer_url_id')->nullable();
            $table->foreign('referer_url_id')->references('id')->on('urls');

            $table->unsignedBigInteger('origin_url_id')->nullable();
            $table->foreign('origin_url_id')->references('id')->on('urls');
        });

        DB::table('requests')->get()->each(function ($request) {
            $userAgentId = null;
            if (! empty($request->user_agent)) {
                $userAgentId = UserAgent::firstOrCreate(['user_agent' => $request->user_agent])->id;
            }

            $mimeTypeId = null;
            if (! empty($request->content_type)) {
                $mimeTypeId = MimeType::firstOrCreate(['mime_type' => $request->content_type])->id;
            }

            $urlId = UrlModel::firstOrCreate(['url' => $request->url])->id;

            $refererUrlId = null;
            if (! empty($request->referer_url)) {
                $refererUrlId = UrlModel::firstOrCreate(['url' => $request->referer_url])->id;
            }

            $originUrlId = null;
            if (! empty($request->origin_url)) {
                $originUrlId = UrlModel::firstOrCreate(['url' => $request->origin_url])->id;
            }

            DB::table('requests')->where('id', $request->id)->update([
                'user_agent_id' => $userAgentId,
                'content_type_mime_type_id' => $mimeTypeId,
                'url_id' => $urlId,
                'referer_url_id' => $refererUrlId,
                'origin_url_id' => $originUrlId,
            ]);
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('user_agent');
            $table->dropColumn('content_type');
            $table->dropColumn('url');
            $table->dropColumn('referer');
            $table->dropColumn('origin');
        });

        DB::statement('ALTER TABLE `requests` ROW_FORMAT=COMPRESSED;');
        DB::statement('ALTER TABLE `urls` ROW_FORMAT=COMPRESSED;');
        DB::statement('ALTER TABLE `user_agents` ROW_FORMAT=COMPRESSED;');
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
            $table->text('url');
            $table->dropForeign(['url_id']);
            $table->dropColumn('url_id');
            $table->text('referer');
            $table->dropForeign(['referer_url_id']);
            $table->dropColumn('referer_url_id');
            $table->text('origin');
            $table->dropForeign(['origin_url_id']);
            $table->dropColumn('origin_url_id');
        });
    }
};
