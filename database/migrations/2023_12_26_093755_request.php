<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Request extends Migration
{
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->enum('method', ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'CONNECT', 'HEAD', 'OPTIONS', 'TRACE'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->enum('method', ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'])->change();
        });
    }
}
