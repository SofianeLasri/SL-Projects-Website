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
            'content_translation_id' => 1,
            'release_status' => null,
            'started_at' => null,
            'ended_at' => null,
        ]);
    }

    public function testPostNewProjectDraftFromExistingPublishedProjectAndEditNameDescContent()
    {
        $project = Project::factory()->withCovers()->withMedias()->create();

        $fields = [
            'project_id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'content' => $project->getTranslationContent(config('app.locale')),
            'square-cover' => $project->square_cover->id,
            'poster-cover' => $project->poster_cover->id,
            'fullwide-cover' => $project->fullwide_cover->id,
            'startDate' => $project->started_at,
            'endDate' => $project->ended_at,
            'release_status' => $project->release_status,
            'medias' => $this->createMediasArrayFromFileUploads($project->medias),
        ];

        $editedFields = array_merge($fields, [
            'name' => 'Edited Project Name',
            'description' => 'Edited Project Description',
            'content' => 'Edited Project Content',
            'release_status' => Project::RELEASE_STATUS_FINISHED,
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
            'release_status' => $editedFields['release_status'],
            'started_at' => $editedFields['startDate'],
            'ended_at' => $editedFields['endDate'],
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
            'project_id' => $project->id,
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'content' => $project->getTranslationContent(config('app.locale')),
            'square-cover' => $project->square_cover->id,
            'poster-cover' => $project->poster_cover->id,
            'fullwide-cover' => $project->fullwide_cover->id,
            'startDate' => $project->started_at,
            'endDate' => $project->ended_at,
            'release_status' => $project->release_status,
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
            'content_translation_id' => 1,
            'release_status' => $fields['release_status'],
            'started_at' => $fields['startDate'],
            'ended_at' => $fields['endDate'],
        ]);
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
            'startDate' => '2021-01-01',
            'endDate' => '2021-01-31',
            'release_status' => Project::RELEASE_STATUS_RUNNING,
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
