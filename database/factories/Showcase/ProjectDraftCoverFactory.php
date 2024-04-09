<?php

namespace Database\Factories\Showcase;

use App\Models\FileUpload;
use App\Models\Showcase\ProjectDraft;
use App\Models\Showcase\ProjectDraftCover;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectDraftCoverFactory extends Factory
{
    protected $model = ProjectDraftCover::class;

    public function definition(): array
    {
        $fileUpload = FileUpload::factory()->image()->create();
        $project = ProjectDraft::factory()->create();

        return [
            'file_upload_id' => $fileUpload->id,
            'project_id' => $project->id,
            'ratio' => $this->faker->randomElement(ProjectDraftCover::RATIO_ENUMS),
        ];
    }

    public function square(): ProjectDraftCoverFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'ratio' => ProjectDraftCover::SQUARE_RATIO,
            ];
        });
    }

    public function poster(): ProjectDraftCoverFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'ratio' => ProjectDraftCover::POSTER_RATIO,
            ];
        });
    }

    public function fullwidth(): ProjectDraftCoverFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'ratio' => ProjectDraftCover::FULLWIDE_RATIO,
            ];
        });
    }

    public function withProject(ProjectDraft $project): ProjectDraftCoverFactory
    {
        return $this->state(function (array $attributes) use ($project) {
            return [
                'project_id' => $project->id,
            ];
        });
    }
}
