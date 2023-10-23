<?php

use App\Models\FileUpload;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'main';

    public function up()
    {
        Schema::create('picture_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FileUpload::class, 'file_upload_id');
            $table->foreignIdFor(FileUpload::class, 'original_file_upload_id')->nullable();
            $table->enum('type', ['thumbnail', 'small', 'medium', 'large', 'original']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('picture_types');
    }
};
