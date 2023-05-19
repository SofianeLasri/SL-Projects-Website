<?php

use App\Models\IpAdress;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_access_tokens', function (Blueprint $table) {
            $mainDbName = DB::connection('main')->getDatabaseName();

            $table->id();
            $table->string('session_id');
            $table->dateTime('expires_at');
            $table->string('token')->unique();
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on("$mainDbName.sessions")
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_access_tokens');
    }
};
