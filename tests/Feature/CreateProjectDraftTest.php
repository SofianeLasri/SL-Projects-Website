<?php

namespace Tests\Feature;

use App\Models\FileUpload;
use App\Models\Showcase\Project;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class CreateProjectDraftTest extends TestCase
{
    use WithoutMiddleware;

    const ROUTE = 'dashboard.ajax.projects.save-draft';

    private string $projectDraftTable;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->projectDraftTable = config('database.connections.showcase.database').'.project_drafts';
    }

    public function testPostNewProjectDraftWithAllFields()
    {
        $fields = $this->getAllFields();

        $response = $this->post(route(self::ROUTE), $fields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $draftId = $response->json('draft_id');

        $this->assertDatabaseHas($this->projectDraftTable, [
            'id' => $draftId,
            'name' => $fields['name'],
            'description' => $fields['description'],
            'content_translation_id' => 1,
            'release_status' => $fields['release_status'],
            'started_at' => $fields['startDate'],
            'ended_at' => $fields['endDate'],
        ]);
    }

    public function testPostNewProjectDraftWithRequiredFields()
    {
        $fields = [
            'name' => 'Project Draft Name',
            'slug' => 'project-draft-name',
        ];

        $response = $this->post(route(self::ROUTE), $fields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $draftId = $response->json('draft_id');

        $this->assertDatabaseHas($this->projectDraftTable, [
            'id' => $draftId,
            'name' => $fields['name'],
            'description' => null,
            'content_translation_id' => 1,
            'release_status' => null,
            'started_at' => null,
            'ended_at' => null,
        ]);
    }

    public function testPostNewProjectDraftFromExistingPublishedProject()
    {
        $project = Project::factory()->withCovers()->withMedias()->create();

        $fields = [
            'project_id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'content' => $project->getTranslationContent(),
            'square-cover' => $project->square_cover->id,
            'poster-cover' => $project->poster_cover->id,
            'fullwide-cover' => $project->fullwide_cover->id,
            'startDate' => $project->started_at,
            'endDate' => $project->ended_at,
            'release_status' => $project->release_status,
            'medias' => $project->medias->pluck('id')->toArray(),
        ];

        $editedFields = array_merge($fields, [
            'name' => 'Edited Project Name',
            'description' => 'Edited Project Description',
            'content' => 'Edited Project Content',
            'release_status' => Project::RELEASE_STATUS_FINISHED,
        ]);

        $response = $this->post(route(self::ROUTE), $editedFields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $draftId = $response->json('draft_id');

        $this->assertDatabaseHas($this->projectDraftTable, [
            'id' => $draftId,
            'name' => $editedFields['name'],
            'description' => $editedFields['description'],
            'release_status' => $editedFields['release_status'],
            'started_at' => $editedFields['startDate'],
            'ended_at' => $editedFields['endDate'],
        ]);
    }

    private function getAllFields(): array
    {
        $coverFileUploads = FileUpload::factory()->image()->count(3)->create();
        $mediaFileUploads = FileUpload::factory()->image()->count(5)->create();

        return [
            'name' => 'Project Name',
            'slug' => 'project-name',
            'description' => 'Project Draft Description',
            'content' => 'Project Draft Content',
            'square-cover' => $coverFileUploads[0]->id,
            'poster-cover' => $coverFileUploads[1]->id,
            'fullwide-cover' => $coverFileUploads[2]->id,
            'startDate' => '2021-01-01',
            'endDate' => '2021-01-31',
            'release_status' => Project::RELEASE_STATUS_RUNNING,
            'medias' => $mediaFileUploads->pluck('id')->toArray(),
        ];
    }
}
