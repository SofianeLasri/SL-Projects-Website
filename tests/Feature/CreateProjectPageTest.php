<?php

namespace Tests\Feature;

use App\Models\FileUpload;
use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectDraft;
use App\Models\Showcase\ProjectMedia;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CreateProjectPageTest extends TestCase
{
    use WithoutMiddleware;

    const DRAFT_ROUTE = 'dashboard.ajax.projects.save-draft';

    const PUBLISH_ROUTE = 'dashboard.ajax.projects.publish';

    private string $projectDraftTable;

    private string $projectTable;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:refresh');

        $projectDraft = new ProjectDraft();
        $this->projectDraftTable = config('database.connections.'.$projectDraft->getConnectionName().'.database').'.'.$projectDraft->getTable();
        $this->projectTable = config('database.connections.'.$projectDraft->getConnectionName().'.database').'.'.app(Project::class)->getTable();
    }

    public function testPostNewProjectDraftWithAllFields()
    {
        $fields = $this->getAllFields();

        $response = $this->post(route(self::DRAFT_ROUTE), $fields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $draftId = $response->json('draft_id');

        $this->assertDatabaseHas($this->projectDraftTable, [
            'id' => $draftId,
            'name' => $fields['name'],
            'description' => $fields['description'],
            'release_status' => $fields['release-status'],
            'started_at' => $fields['start-date'],
            'ended_at' => $fields['end-date'],
        ]);
    }

    public function testPostNewProjectDraftWithRequiredFields()
    {
        $fields = [
            'name' => 'Project Draft Name',
            'slug' => 'project-draft-name',
        ];

        $response = $this->post(route(self::DRAFT_ROUTE), $fields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $draftId = $response->json('draft_id');

        $this->assertDatabaseHas($this->projectDraftTable, [
            'id' => $draftId,
            'name' => $fields['name'],
            'description' => null,
            'release_status' => null,
            'started_at' => null,
            'ended_at' => null,
        ]);
    }

    public function testPostNewProjectDraftFromExistingPublishedProjectAndEditNameDescContent()
    {
        $project = Project::factory()->withCovers()->withMedias()->create();

        $fields = [
            'project-id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'content' => $project->getTranslationContent(config('app.locale')),
            'square-cover' => $project->square_cover->id,
            'poster-cover' => $project->poster_cover->id,
            'fullwide-cover' => $project->fullwide_cover->id,
            'start-date' => $project->started_at,
            'end-date' => $project->ended_at,
            'release-status' => $project->release_status,
            'medias' => $this->createMediasArrayFromFileUploads($project->medias),
        ];

        $editedFields = array_merge($fields, [
            'name' => 'Edited Project Name',
            'description' => 'Edited Project Description',
            'content' => 'Edited Project Content',
            'release-status' => Project::RELEASE_STATUS_FINISHED,
        ]);

        $response = $this->post(route(self::DRAFT_ROUTE), $editedFields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $draftId = $response->json('draft_id');

        $this->assertDatabaseHas($this->projectDraftTable, [
            'id' => $draftId,
            'name' => $editedFields['name'],
            'description' => $editedFields['description'],
            'release_status' => $editedFields['release-status'],
            'started_at' => $editedFields['start-date'],
            'ended_at' => $editedFields['end-date'],
        ]);

        $draftContent = ProjectDraft::find($draftId)->getTranslationContent(config('app.locale'));

        $this->assertEquals($editedFields['content'], $draftContent);

        $draftMedias = ProjectDraft::find($draftId)->medias;

        $this->assertCount(count($editedFields['medias']), $draftMedias);
        $this->assertCount(count($project->medias), $draftMedias);
    }

    public function testPostNewProjectDraftFromExistingPublishedProjectAndEditMedias()
    {
        $project = Project::factory()->withCovers()->withMedias()->create();

        $fields = [
            'project-id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'content' => $project->getTranslationContent(config('app.locale')),
            'square-cover' => $project->square_cover->id,
            'poster-cover' => $project->poster_cover->id,
            'fullwide-cover' => $project->fullwide_cover->id,
            'start-date' => $project->started_at,
            'end-date' => $project->ended_at,
            'release-status' => $project->release_status,
            'medias' => $this->createMediasArrayFromFileUploads($project->medias),
        ];

        $newMediaFileUploads = FileUpload::factory()->image()->count(2)->create();

        $editedFields = array_merge($fields, [
            'medias' => $this->createMediasArrayFromFileUploads($newMediaFileUploads),
        ]);

        $response = $this->post(route(self::DRAFT_ROUTE), $editedFields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $draftId = $response->json('draft_id');

        $draftMedias = ProjectDraft::find($draftId)->medias;

        $this->assertCount(2, $draftMedias);
        $this->assertNotCount(count($project->medias), $draftMedias);
    }

    public function testPostNewProjectWithAllFields()
    {
        $fields = $this->getAllFields();

        $response = $this->post(route(self::PUBLISH_ROUTE), $fields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $projectId = $response->json('project_id');

        $this->assertDatabaseHas($this->projectTable, [
            'id' => $projectId,
            'name' => $fields['name'],
            'description' => $fields['description'],
            'release_status' => $fields['release-status'],
            'started_at' => $fields['start-date'],
            'ended_at' => $fields['end-date'],
        ]);
    }

    public function testPostNewProjectWithRequiredFields()
    {
        $fields = $this->getAllFields();
        unset($fields['square-cover']);
        unset($fields['poster-cover']);
        unset($fields['fullwide-cover']);
        unset($fields['medias']);
        unset($fields['end-date']);

        $response = $this->post(route(self::PUBLISH_ROUTE), $fields);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $projectId = $response->json('project_id');

        $this->assertDatabaseHas($this->projectTable, [
            'id' => $projectId,
            'name' => $fields['name'],
            'description' => $fields['description'],
            'release_status' => $fields['release-status'],
            'started_at' => $fields['start-date'],
            'ended_at' => null,
        ]);
    }

    public function testPostNewProjectWithMissingFields()
    {
        $fields = [
            'name' => 'Project Name',
            'slug' => 'project-name',
            'status' => Project::STATUS_DRAFT,
        ];

        $response = $this->post(route(self::PUBLISH_ROUTE), $fields);

        $response->assertStatus(302);
    }

    public function testModifyExistingProject()
    {
        $project = Project::factory()->withCovers()->withMedias()->create();

        echo $project->content_translation_id;

        $fields = [
            'project-id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'content' => $project->getTranslationContent(config('app.locale')),
            'square-cover' => $project->square_cover->id,
            'poster-cover' => $project->poster_cover->id,
            'fullwide-cover' => $project->fullwide_cover->id,
            'start-date' => $project->started_at,
            'end-date' => $project->ended_at,
            'release-status' => Project::RELEASE_STATUS_FINISHED,
            'medias' => $this->createMediasArrayFromFileUploads($project->medias),
        ];

        $updatedData = array_merge($fields, [
            'name' => 'Updated Project Name',
            'description' => 'Updated Project Description',
            'content' => 'Updated Project Content',
        ]);

        $this->post(route(self::PUBLISH_ROUTE, $project->id), $updatedData)
            ->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas($this->projectTable, [
            'id' => $project->id,
            'name' => $updatedData['name'],
            'description' => $updatedData['description'],
            'content_translation_id' => $project->content_translation_id,
            'release_status' => $updatedData['release-status'],
            'started_at' => $updatedData['start-date'],
            'ended_at' => $updatedData['end-date'],
        ]);

        $updatedProjectContent = Project::find($project->id)->getTranslationContent(config('app.locale'));
        $this->assertEquals($updatedData['content'], $updatedProjectContent);
    }

    private function getAllFields(): array
    {
        $coverFileUploads = FileUpload::factory()->image()->count(3)->create();
        $mediaFileUploads = FileUpload::factory()->image()->count(5)->create();

        return [
            'name' => 'Project Name',
            'slug' => 'project-name',
            'description' => 'Project Description',
            'content' => 'Project Content',
            'square-cover' => $coverFileUploads[0]->id,
            'poster-cover' => $coverFileUploads[1]->id,
            'fullwide-cover' => $coverFileUploads[2]->id,
            'start-date' => '2021-01-01',
            'end-date' => '2021-01-31',
            'release-status' => Project::RELEASE_STATUS_RUNNING,
            'medias' => $this->createMediasArrayFromFileUploads($mediaFileUploads),
        ];
    }

    private function createMediasArrayFromFileUploads(Collection $fileUploads): array
    {
        $mediasArray = [];
        $displayOrder = 1;
        foreach ($fileUploads as $fileUpload) {
            $mediasArray[] = [
                'display_order' => $displayOrder,
                'name' => 'Media Name '.$displayOrder,
                'type' => ProjectMedia::TYPE_FILEUPLOAD,
                'file_upload_id' => $fileUpload->id,
                'link' => null,
            ];
        }

        return $mediasArray;
    }
}
