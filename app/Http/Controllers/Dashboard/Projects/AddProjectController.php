<?php

namespace App\Http\Controllers\Dashboard\Projects;

use App\Http\Controllers\Controller;
use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectDraft;
use App\Models\Translation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddProjectController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'project_id' => 'nullable|integer|exists:showcase.projects,id',
        ]);

        if ($request->input('project_id')) {
            $project = Project::find($request->input('project_id'));
            $draft = $project->draft;

            $fields = [
                'project_id' => $project->id,
                'slug' => $project->slug,
            ];

            if ($draft) {
                $fields = array_merge($fields, [
                    'name' => $draft->name,
                    'description' => $draft->description,
                    'square-cover' => $project->square_cover,
                    'poster-cover' => $project->poster_cover,
                    'fullwide-cover' => $project->fullwide_cover,
                    'startDate' => $draft->started_at,
                    'endDate' => $draft->ended_at,
                    'release_status' => $draft->release_status,
                    'content' => $draft->getTranslationContent(),
                    'medias' => $draft->medias,
                ]);
            } else {
                $fields = array_merge($fields, [
                    'name' => $project->name,
                    'description' => $project->description,
                    'square-cover' => $project->square_cover,
                    'poster-cover' => $project->poster_cover,
                    'fullwide-cover' => $project->fullwide_cover,
                    'startDate' => $project->started_at,
                    'endDate' => $project->ended_at,
                    'release_status' => $project->release_status,
                    'content' => $project->getTranslationContent(),
                    'medias' => $project->medias,
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
                'startDate' => null,
                'endDate' => null,
                'release_status' => Project::RELEASE_STATUS_RUNNING,
                'content' => '',
                'medias' => [],
            ];
        }

        return view('websites.dashboard.projects.add-project', [
            'fields' => $fields,
        ]);
    }

    public function saveDraft(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'sometimes|nullable|integer|exists:showcase.projects,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'content' => 'sometimes|nullable|string',
            'square-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'poster-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'fullwide-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'startDate' => 'sometimes|nullable|date',
            'endDate' => 'sometimes|nullable|date',
            'release_status' => ['sometimes', 'nullable', 'string', 'in:'.implode(',', Project::RELEASE_STATUS_ENUMS)],
            'medias' => 'sometimes|nullable|array',
        ]);

        if ($request->input('project_id')) {
            $project = Project::find($request->input('project_id'));
        } else {
            $project = Project::createEmptyProjectForDraft($request->input('slug'), $request->input('name'));
        }

        $draft = ProjectDraft::findOrCreateDraft($project->id, $request->input('name'));

        $draft->name = $request->input('name');
        $draft->description = $request->input('description');

        $contentTranslation = Translation::updateOrCreateTranslation(
            $draft->getContentTranslationKey(),
            config('app.locale'),
            $request->input('content') ?? ''
        );

        $draft->content_translation_id = $contentTranslation->id;
        $draft->release_status = $request->input('release_status');
        $draft->started_at = $request->input('startDate');
        $draft->ended_at = $request->input('endDate');
        $draft->save();

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
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
}
