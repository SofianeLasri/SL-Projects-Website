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
        $coverFileUploads = FileUpload::factory()->image()->count(3)->create();
        $mediaFileUploads = FileUpload::factory()->image()->count(5)->create();

        $fields = [
            'name' => 'Project Draft Name',
            'slug' => 'project-draft-name',
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
}
