<?php

namespace Database\Factories\Showcase;

use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectCover;
use App\Models\Showcase\ProjectMedia;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $startedAt = Carbon::parse($this->faker->dateTimeThisYear());
        $endedAt = $startedAt->copy()->addDays($this->faker->numberBetween(1, 30));
        $contentTranslation = Translation::factory()->create();
        return [
            'status' => $this->faker->randomElement(Project::STATUS_ENUMS),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'content_translation_id' => $contentTranslation->id,
            'release_status' => $this->faker->randomElement(Project::RELEASE_STATUS_ENUMS),
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
            'created_at' => Carbon::now()->subDays($this->faker->numberBetween(1, 30)),
            'updated_at' => Carbon::now(),
        ];
    }

    public function withCovers(): ProjectFactory
    {
        return $this->afterCreating(function (Project $project) {
            ProjectCover::factory()->withProject($project)->square()->create();
            ProjectCover::factory()->withProject($project)->poster()->create();
            ProjectCover::factory()->withProject($project)->fullwidth()->create();
        });
    }

    public function withMedias(): ProjectFactory
    {
        return $this->afterCreating(function (Project $project) {
            $project->medias()->saveMany(ProjectMedia::factory()->withProject($project)->count(3)->create());
        });
    }
}
