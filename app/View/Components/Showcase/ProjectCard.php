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
        if (! hash_equals(Str::kebab($projectSlug), $projectSlug)) {
            throw new Exception('Project name must be kebab case', 500);
        }

        $this->projectSlug = 'placeholder';
        $this->projectName = 'Placeholder';
        $this->projectCategoryName = 'Placeholder';
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
