<?php

namespace App\View\Components\Showcase;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectDateContainer extends Component
{
    public int $year;
    public array $projects;
    private string $id;

    /**
     * @throws Exception
     */
    public function __construct(int $year, array $projects)
    {
        // TODO: Les projets doivent être de la classe Project
        $this->year = $year;
        $this->projects = $projects;
        $this->id = "projectDateContainer-" . uniqid();
    }
    public function render(): View
    {
        return view('components.showcase.project-date-container', [
            'id' => $this->id
        ]);
    }
}
