<?php

namespace App\Http\Controllers\Showcase;

use App\Http\Controllers\Controller;
use App\Models\Showcase\Project;
use App\Models\Showcase\ProjectDraft;

class ProjectController extends Controller
{
    public function index()
    {
        return view('websites.showcase.pages.project');
    }

    public function preview(string $projectSlug, string $draftId)
    {
        if (! Project::where('slug', $projectSlug)->exists()) {
            abort(404);
        }
        if (! ProjectDraft::where('id', $draftId)->exists()) {
            abort(404);
        }

        return view('websites.showcase.pages.project', [
            'draft' => ProjectDraft::find($draftId),
        ]);
    }
}
