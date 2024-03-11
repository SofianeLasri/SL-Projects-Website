<?php

namespace Database\Factories\Showcase;

use App\Models\FileUpload;
use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectCover;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectCoverFactory extends Factory
{
    protected $model = ProjectCover::class;

    public function definition(): array
    {
        $fileUpload = FileUpload::factory()->image()->create();
        $project = Project::factory()->create();

        return [
            'file_upload_id' => $fileUpload->id,
            'project_id' => $project->id,
            'ratio' => $this->faker->randomElement(ProjectCover::RATIO_ENUMS),
        ];
    }

    public function square(): ProjectCoverFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'ratio' => ProjectCover::SQUARE_RATIO,
            ];
        });
    }

    public function poster(): ProjectCoverFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'ratio' => ProjectCover::POSTER_RATIO,
            ];
        });
    }

    public function fullwidth(): ProjectCoverFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'ratio' => ProjectCover::FULLWIDE_RATIO,
            ];
        });
    }

    public function withProject(Project $project): ProjectCoverFactory
    {
        return $this->state(function (array $attributes) use ($project) {
            return [
                'project_id' => $project->id,
            ];
        });
    }
}
