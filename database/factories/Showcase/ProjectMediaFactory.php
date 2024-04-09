<?php

namespace Database\Factories\Showcase;

use App\Models\FileUpload;
use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectMedia;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProjectMediaFactory extends Factory
{
    protected $model = ProjectMedia::class;

    public function definition(): array
    {
        $randIsLink = $this->faker->boolean();
        $project = Project::factory()->create();
        $displayOrder = ProjectMedia::where('project_id', $project->id)->max('display_order') + 1;
        $nameTranslation = Translation::factory()->create();

        $fields = [
            'project_id' => $project->id,
            'display_order' => $displayOrder,
            'name_translation_id' => $nameTranslation->id,
            'created_at' => Carbon::now()->subDays($this->faker->numberBetween(1, 30)),
            'updated_at' => Carbon::now(),
        ];

        if ($randIsLink) {
            return array_merge($fields, [
                'type' => ProjectMedia::TYPE_LINK,
                'file_upload_id' => null,
                'link' => $this->faker->url(),
            ]);
        }

        $fileUpload = FileUpload::factory()->image()->create();

        return array_merge($fields, [
            'type' => ProjectMedia::TYPE_FILEUPLOAD,
            'file_upload_id' => $fileUpload->id,
            'link' => null,
        ]);
    }

    public function link(): ProjectMediaFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ProjectMedia::TYPE_LINK,
                'file_upload_id' => null,
                'link' => $this->faker->url(),
            ];
        });
    }

    public function fileUpload(): ProjectMediaFactory
    {
        return $this->state(function (array $attributes) {
            $fileUpload = FileUpload::factory()->image()->create();
            return [
                'type' => ProjectMedia::TYPE_FILEUPLOAD,
                'file_upload_id' => $fileUpload->id,
                'link' => null,
            ];
        });
    }

    public function withProject(Project $project): ProjectMediaFactory
    {
        return $this->state(function (array $attributes) use ($project) {
            return [
                'project_id' => $project->id,
            ];
        });
    }
}
