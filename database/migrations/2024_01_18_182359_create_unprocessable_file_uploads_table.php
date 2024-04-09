<?php

use App\Models\FileUpload;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'main';

    public function up(): void
    {
        Schema::create('unprocessable_file_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FileUpload::class)
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->text('reason')->nullable();
            $table->enum('task', ['conversion'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unprocessable_file_uploads');
    }
};
