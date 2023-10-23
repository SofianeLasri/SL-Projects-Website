<?php

namespace App\Http\Controllers\Dashboard\Projects;

use App\Http\Controllers\Controller;
use App\Models\Showcase\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddProjectController extends Controller
{
    public function index()
    {
        return view('websites.dashboard.projects.add-project');
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
