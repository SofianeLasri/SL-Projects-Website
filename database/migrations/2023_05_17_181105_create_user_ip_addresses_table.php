<?php

use App\Models\IpAdress;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'main';

    public function up(): void
    {
        Schema::create('user_ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(IpAdress::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ip_addresses');
    }
};
