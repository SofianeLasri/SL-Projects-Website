<?php

use App\Models\FileUpload;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingImageConversionsTable extends Migration
{
    protected $connection = 'main';

    public function up(): void
    {
        Schema::create('pending_image_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FileUpload::class);
            $table->enum('type', ['thumbnail', 'small', 'medium', 'large', 'original']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_image_conversions');
    }
}
