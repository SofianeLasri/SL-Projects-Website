<?php

namespace App\View\Components\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use InvalidArgumentException;

class StepsGroupList extends Component
{
    public string $id;

    public array $steps;

    public string $title;

    public bool $useCheckIcon;

    public function __construct(array $steps, string $title, bool $useCheckIcon = false, ?string $id = null)
    {
        $this->steps = $steps;
        $this->title = $title;
        $this->useCheckIcon = $useCheckIcon;
        $this->id = $id ?? uniqid('stepGroupList_');

        $this->validateSteps($steps);
    }

    private function validateSteps(array $steps): void
    {
        $ids = [];
        foreach ($steps as $step) {
            if (! isset($step['title'])) {
                throw new InvalidArgumentException('Step title is required');
            }

            if (! isset($step['id'])) {
                throw new InvalidArgumentException('Step id is required');
            }

            if (in_array($step['id'], $ids)) {
                throw new InvalidArgumentException('Step id must be unique');
            }
            $ids[] = $step['id'];
        }
    }

    public function render(): View
    {
        return view('components.dashboard.steps-group-list');
    }
}
