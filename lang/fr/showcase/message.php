<?php

use App\Models\Showcase\Project;

return [
    'meta' => [
        'desc' => 'La maison de tous les projets de Sofiane Lasri.',
        'name' => 'SL-Projects',
    ],
    'project_status' => [
        Project::RELEASE_STATUS_FINISHED => 'Terminé',
        Project::RELEASE_STATUS_RUNNING => 'En cours',
        Project::RELEASE_STATUS_CANCELLED => 'Annulé',
    ],
];
