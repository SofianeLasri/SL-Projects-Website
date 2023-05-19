<?php

namespace App\View\Components\Showcase;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class ProjectsFilter extends Component
{
    public array $filters;
    public string $title;
    private string $id;

    /**
     * @throws Exception
     */
    public function __construct(array $filters, string $title)
    {
        foreach ($filters as $filter) {
            if (!isset($filter['name']) || !isset($filter['label'])) {
                throw new Exception('Filter must have name and label');
            } else {
                if (!hash_equals(Str::kebab($filter['name']), $filter['name'])) {
                    throw new Exception('Filter name must be kebab case', 500);
                }
            }
        }
        $this->filters = $filters;
        $this->title = $title;
        $this->id = "projectsFilter-" . uniqid();
    }

    public function render(): View
    {
        return view('components.showcase.projects-filter', [
            'id' => $this->id
        ]);
    }
}
