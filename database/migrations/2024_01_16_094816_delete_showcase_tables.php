<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'showcase';

    public function up(): void
    {
        Schema::dropAllTables();
    }
};
