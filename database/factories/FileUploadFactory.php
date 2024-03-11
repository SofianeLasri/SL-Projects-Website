<?php

namespace Database\Factories;

use App\Models\FileUpload;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class FileUploadFactory extends Factory
{
    protected $model = FileUpload::class;

    const FILE_TYPES = [
        'image' => [
            'jpg',
            'png',
            'gif',
            'webp',
            'avif',
        ],
        'video' => [
            'mp4',
            'webm',
        ],
        'audio' => [
            'mp3',
            'wav',
            'ogg',
        ],
        'document' => [
            'pdf',
            'doc',
            'docx',
        ],
    ];

    public function definition(): array
    {
        return $this->createFileUpload();
    }

    public function image(): FileUploadFactory
    {
        return $this->state(function (array $attributes) {
            return $this->createFileUpload('image');
        });
    }

    private function createFileUpload(?string $filetype = null): array
    {
        $filetype = $filetype ?? $this->faker->randomElement(array_keys(self::FILE_TYPES));
        $name = $this->faker->word();
        $extension = $this->faker->randomElement(self::FILE_TYPES[$filetype]);
        $filename = Str::kebab($name).'.'.$extension;
        $path = $this->faker->numberBetween(2022, 2025).'/'.$this->faker->numberBetween(1, 12).'/'.$this->faker->numberBetween(1, 28).'/'.$filename;

        return [
            'name' => $name,
            'description' => $this->faker->text(),
            'filename' => $filename,
            'path' => $path,
            'type' => $filetype,
            'size' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
