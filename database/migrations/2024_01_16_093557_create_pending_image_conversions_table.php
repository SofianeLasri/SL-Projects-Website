<?php

use App\Models\FileUpload;
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
        Schema::create('pending_image_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FileUpload::class)
                ->constrained(table: 'file_uploads')
                ->cascadeOnDelete();
            $table->enum('type', ['thumbnail', 'small', 'medium', 'large', 'original']);
            $table->enum('status', ['pending', 'processing'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_image_conversions');
    }
};
