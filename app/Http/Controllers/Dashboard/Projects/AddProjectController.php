<?php

namespace App\Http\Controllers\Dashboard\Projects;

use App\Http\Controllers\Controller;
use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectDraft;
use App\Models\Translation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddProjectController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);

        return view('websites.dashboard.projects.add-project');
    }

    public function saveDraft(Request $request): JsonResponse
    {
        $request->validate([
            'project_id' => 'sometimes|nullable|integer|exists:projects,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'square_cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'poster-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'fullwide-cover' => 'sometimes|nullable|integer|exists:file_uploads,id',
            'startDate' => 'sometimes|nullable|date',
            'endDate' => 'sometimes|nullable|date',
            'release_status' => ['sometimes', 'nullable', 'string', 'in:'.implode(',', Project::RELEASE_STATUS_ENUMS)],
            'content' => 'sometimes|nullable|string',
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
            Str::upper(config('app.locale')),
            $request->input('content'),
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
