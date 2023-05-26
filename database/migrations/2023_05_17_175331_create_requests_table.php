<?php

use App\Models\IpAdress;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection = 'main';

    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(IpAdress::class);
            $table->string('country_code')->nullable();
            $table->string('url');
            $table->enum('method', ['GET', 'POST', 'PUT', 'DELETE', 'PATCH']);
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->string('origin')->nullable();
            $table->string('content_type')->nullable();
            $table->integer('content_length')->nullable();
            $table->integer('status_code')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
