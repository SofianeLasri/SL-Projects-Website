<?php

namespace App\Http\Controllers\Dashboard\Projects;

use App\Http\Controllers\Controller;
use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectBase;
use App\Models\Showcase\ProjectCover;
use App\Models\Showcase\ProjectDraft;
use App\Models\Showcase\ProjectDraftCover;
use App\Models\Showcase\ProjectDraftMedia;
use App\Models\Showcase\ProjectMedia;
use App\Rules\ProjectMediasArraySchemeRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectEditorController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'project_id' => 'sometimes|integer|exists:showcase.projects,id',
            'draft_id' => 'sometimes|integer|exists:showcase.project_drafts,id',
        ]);

        if ($request->has('project_id') || $request->has('draft_id')) {

            if ($request->has('draft_id')) {
                $draft = ProjectDraft::find($request->input('draft_id'));
                $project = $draft->project;
                $fields = ['draft_id' => $draft->id];
            } else {
                $project = Project::find($request->input('project_id'));
            }

            $fields = array_merge($fields, [
                'project_id' => $project->id,
                'slug' => $project->slug,
                'name' => $project->name,
                'description' => $project->description,
                'square-cover' => $project->square_cover,
                'poster-cover' => $project->poster_cover,
                'fullwide-cover' => $project->fullwide_cover,
                'start_date' => $project->started_at,
                'end_date' => $project->ended_at,
                'release_status' => $project->release_status,
                'content' => $project->getTranslationContent(config('app.locale')),
                'medias' => $project->medias,
            ]);

            if (! empty($draft)) {
                $fields = array_merge($fields, [
                    'name' => $draft->name,
                    'description' => $draft->description,
                    'square-cover' => $project->square_cover,
                    'poster-cover' => $project->poster_cover,
                    'fullwide-cover' => $project->fullwide_cover,
                    'start_date' => $draft->started_at,
                    'end_date' => $draft->ended_at,
                    'release_status' => $draft->release_status,
                    'content' => $draft->getTranslationContent(config('app.locale')),
                    'medias' => $draft->medias,
                ]);
            }
        } else {
            $fields = [
                'project_id' => null,
                'slug' => '',
                'name' => '',
                'description' => '',
                'square-cover' => null,
                'poster-cover' => null,
                'fullwide-cover' => null,
                'start_date' => null,
                'end_date' => null,
                'release_status' => Project::RELEASE_STATUS_RUNNING,
                'content' => '',
                'medias' => [],
            ];
        }

        return view('websites.dashboard.projects.editor', [
            'fields' => $fields,
        ]);
    }

    public function saveDraft(Request $request): JsonResponse
    {
        $request->validate([
            'draft_id' => 'sometimes|nullable|integer|exists:showcase.project_drafts,id',
            'project_id' => 'sometimes|nullable|integer|exists:showcase.projects,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'content' => 'sometimes|nullable|string',
            'square-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'poster-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'fullwide-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date',
            'release_status' => ['sometimes', 'nullable', 'string', 'in:'.implode(',', Project::RELEASE_STATUS_ENUMS)],
            'medias' => ['sometimes', 'nullable', 'array', new ProjectMediasArraySchemeRule],
        ]);

        $locale = config('app.locale');

        if ($request->input('draft_id')) {
            $draft = ProjectDraft::find($request->input('draft_id'));
        } else {
            if ($request->input('project_id')) {
                $project = Project::find($request->input('project_id'));
            } else {
                $project = Project::createEmptyProjectForDraft($request->input('slug'), $request->input('name'));
            }

            $draft = ProjectDraft::findOrCreateDraft($project->id, $request->input('name'));
        }

        $this->setProjectAttributes($request, $draft, $locale);

        $savedMedias = ProjectDraftMedia::forProjectDraft($draft);
        if ($savedMedias->exists()) {
            $savedMedias->delete();
        }

        if ($request->input('medias')) {
            foreach ($request->input('medias') as $media) {
                $newlySavedMedia = ProjectDraftMedia::create([
                    'project_draft_id' => $draft->id,
                    'display_order' => $media['display_order'],
                    'type' => $media['type'],
                    'file_upload_id' => $media['file_upload_id'],
                    'link' => $media['link'],
                ]);
                $newlySavedMedia->setNameTranslation($media['name'], $locale);
            }
        }

        $savedCovers = ProjectDraftCover::forProjectDraft($draft);
        if ($savedCovers->exists()) {
            $savedCovers->delete();
        }

        if ($request->input('square-cover')) {
            $draft->covers()->create([
                'ratio' => ProjectDraftCover::SQUARE_RATIO,
                'file_upload_id' => $request->input('square-cover'),
            ]);
        }

        if ($request->input('poster-cover')) {
            $draft->covers()->create([
                'ratio' => ProjectDraftCover::POSTER_RATIO,
                'file_upload_id' => $request->input('poster-cover'),
            ]);
        }

        if ($request->input('fullwide-cover')) {
            $draft->covers()->create([
                'ratio' => ProjectDraftCover::FULLWIDE_RATIO,
                'file_upload_id' => $request->input('fullwide-cover'),
            ]);
        }

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'url' => route('showcase.preview-project', ['projectSlug' => $draft->project->slug, 'draftId' => $draft->id]),
        ]);
    }

    public function publishProject(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'sometimes|nullable|integer|exists:showcase.projects,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'square-cover' => 'sometimes|integer|exists:file_uploads,id',
            'poster-cover' => 'sometimes|integer|exists:file_uploads,id',
            'fullwide-cover' => 'sometimes|integer|exists:file_uploads,id',
            'start_date' => 'required|date',
            'end_date' => 'sometimes|nullable|date',
            'release_status' => ['required', 'string', 'in:'.implode(',', Project::RELEASE_STATUS_ENUMS)],
            'medias' => ['sometimes', 'nullable', 'array', new ProjectMediasArraySchemeRule],
        ]);

        $locale = config('app.locale');

        if ($request->input('project_id')) {
            $project = Project::find($request->input('project_id'));
        } else {
            $project = new Project();
        }

        $project->slug = $request->input('slug');
        $this->setProjectAttributes($request, $project, $locale);

        $savedMedias = ProjectMedia::forProject($project);
        if ($savedMedias->exists()) {
            $savedMedias->delete();
        }

        if ($request->input('medias')) {
            foreach ($request->input('medias') as $media) {
                $newlySavedMedia = ProjectMedia::create([
                    'project_id' => $project->id,
                    'display_order' => $media['display_order'],
                    'type' => $media['type'],
                    'file_upload_id' => $media['file_upload_id'],
                    'link' => $media['link'],
                ]);
                $newlySavedMedia->setNameTranslation($media['name'], $locale);
            }
        }

        $savedCovers = ProjectCover::forProject($project);
        if ($savedCovers->exists()) {
            $savedCovers->delete();
        }

        if ($request->input('square-cover')) {
            $project->covers()->create([
                'ratio' => ProjectCover::SQUARE_RATIO,
                'file_upload_id' => $request->input('square-cover'),
            ]);
        }

        if ($request->input('poster-cover')) {
            $project->covers()->create([
                'ratio' => ProjectCover::POSTER_RATIO,
                'file_upload_id' => $request->input('poster-cover'),
            ]);
        }

        if ($request->input('fullwide-cover')) {
            $project->covers()->create([
                'ratio' => ProjectCover::FULLWIDE_RATIO,
                'file_upload_id' => $request->input('fullwide-cover'),
            ]);
        }

        return response()->json([
            'success' => true,
            'project_id' => $project->id,
            'url' => route('showcase.project', ['projectSlug' => $project->slug]),
        ]);
    }

    public function checkSlug(Request $request): JsonResponse
    {
        $request->validate([
            'slug' => 'required|string|max:255',
        ]);

        $slug = $request->input('slug');
        $slugAlreadyUsed = Project::where('slug', $slug)->exists();

        return response()->json([
            'slugAlreadyUsed' => $slugAlreadyUsed,
        ]);
    }

    public function checkName(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $name = $request->input('name');
        $nameAlreadyUsed = Project::where('name', $name)->exists();

        return response()->json([
            'nameAlreadyUsed' => $nameAlreadyUsed,
        ]);
    }

    /**
     * @param  ProjectDraft  $project
     * @param  mixed  $locale
     */
    private function setProjectAttributes(Request $request, ProjectBase $project, string $locale): void
    {
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->release_status = $request->input('release_status');
        $project->started_at = $request->input('start_date');
        $project->ended_at = $request->input('end_date');
        $project->save();

        $project->setTranslationContent($request->input('content', ''), $locale);
    }
}
