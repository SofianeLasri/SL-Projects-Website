<?php

namespace App\View\Components\Showcase;

use App\Models\FileUpload;
use App\Models\Showcase\Project;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class ProjectCard extends Component
{
    public string $projectSlug;
    private ?FileUpload $coverFile = null;
    private string $projectCategoryName;
    /**
     * @var mixed|string
     */
    private string $projectName;

    /**
     * @throws Exception
     */
    public function __construct(string $projectSlug)
    {
        // TODO: Pouvoir passer en paramètre un objet Project
        if (!hash_equals(Str::kebab($projectSlug), $projectSlug)) {
            throw new Exception('Project name must be kebab case', 500);
        }
        $this->projectSlug = $projectSlug;
        $projectModel = Project::where('slug', $projectSlug)->first();

        if($projectSlug !== 'placeholder') {
            if (!$projectModel) {
                throw new Exception('Project not found', 404);
            }

            $this->projectName = $projectModel->name;

            $coverFile = $projectModel->getCoverFile()->first();

            if ($coverFile) {
                $this->coverFile = $coverFile->getLargeVariant()->first();
            }

            $projectCategories = $projectModel->getCategories()->get();

            if ($projectCategories->count() > 0) {
                if ($projectCategories->count() > 1) {
                    $this->projectCategoryName = "Multiple Categories";
                } else {
                    $this->projectCategoryName = $projectCategories->first()->name;
                }
            } else {
                $this->projectCategoryName = "No Category";
            }
        } else {
            $this->projectName = "Placeholder";
            $this->projectCategoryName = "Placeholder";
        }
    }

    public function render(): View
    {
        return view('components.showcase.project-card', [
            'projectSlug' => $this->projectSlug,
            'coverFile' => $this->coverFile,
            'projectName' => $this->projectName,
            'projectCategoryName' => $this->projectCategoryName,
        ]);
    }
}
