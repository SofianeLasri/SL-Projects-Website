<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class ProjectsController extends Controller
{
    public function index()
    {
        $firstFilter = [
            [
                'name' => 'source-engine',
                'label' => 'Source Engine'
            ],
            [
                'name' => 'developpement-web',
                'label' => 'Développement Web'
            ],
            [
                'name' => 'developpement-mobile',
                'label' => 'Développement Mobile'
            ],
            [
                'name' => 'unity',
                'label' => 'Unity'
            ],
            [
                'name' => 'unreal-engine',
                'label' => 'Unreal Engine'
            ],
            [
                'name' => 'game-design',
                'label' => 'Game Design'
            ],
            [
                'name' => 'gameplay-programming',
                'label' => 'Gameplay Programming'
            ],
            [
                'name' => 'gameplay-design',
                'label' => 'Gameplay Design'
            ],
            [
                'name' => 'gameplay-art',
                'label' => 'Gameplay Art'
            ],
            [
                'name' => 'gameplay-sound',
                'label' => 'Gameplay Sound'
            ],
            [
                'name' => 'gameplay-animation',
                'label' => 'Gameplay Animation'
            ],
            [
                'name' => 'gameplay-level-design',
                'label' => 'Gameplay Level Design'
            ],
            [
                'name' => 'gameplay-ui-design',
                'label' => 'Gameplay UI Design'
            ],
            [
                'name' => 'gameplay-character-design',
                'label' => 'Gameplay Character Design'
            ],
            [
                'name' => 'gameplay-vfx',
                'label' => 'Gameplay VFX'
            ],
            [
                'name' => 'gameplay-ux',
                'label' => 'Gameplay UX'
            ],
            [
                'name' => 'gameplay-ai',
                'label' => 'Gameplay AI'
            ],
            [
                'name' => 'gameplay-network',
                'label' => 'Gameplay Network'
            ],
            [
                'name' => 'gameplay-multiplayer',
                'label' => 'Gameplay Multiplayer'
            ],
            [
                'name' => 'gameplay-physics',
                'label' => 'Gameplay Physics'
            ],
            [
                'name' => 'gameplay-scripting',
                'label' => 'Gameplay Scripting'
            ],
            [
                'name' => 'gameplay-3d',
                'label' => 'Gameplay 3D'
            ],
            [
                'name' => 'gameplay-2d',
                'label' => 'Gameplay 2D'
            ],
            [
                'name' => 'gameplay-3d-animation',
                'label' => 'Gameplay 3D Animation'
            ]
        ];

        $secondFilter = [
            [
                'name' => '2023',
                'label' => '2023'
            ],
            [
                'name' => '2022',
                'label' => '2022'
            ],
            [
                'name' => '2021',
                'label' => '2021'
            ],
            [
                'name' => '2020',
                'label' => '2020'
            ],
            [
                'name' => '2019',
                'label' => '2019'
            ],
            [
                'name' => '2018',
                'label' => '2018'
            ],
            [
                'name' => '2017',
                'label' => '2017'
            ],
            [
                'name' => '2016',
                'label' => '2016'
            ]
        ];

        $filters = [
            [
                'title' => 'Catégories',
                'filter' => $firstFilter
            ],
            [
                'title' => 'Années',
                'filter' => $secondFilter
            ]
        ];

        $fakeProjects = [
            [
                'name' => 'Projet 1',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2021-01-01'),
                'project_end_date' => new Carbon('2022-09-01'),
            ],
            [
                'name' => 'Projet 2',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2021-01-01'),
                'project_end_date' => new Carbon('2021-09-01'),
            ],
            [
                'name' => 'Projet 3',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2016-01-01'),
                'project_end_date' => new Carbon('2022-09-01'),
            ],
            [
                'name' => 'Projet 4',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2016-01-01'),
                'project_end_date' => new Carbon('2016-09-01'),
            ],
            [
                'name' => 'Projet 5',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2016-01-01'),
                'project_end_date' => new Carbon('2017-09-01'),
            ],
            [
                'name' => 'Projet 6',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2017-01-01'),
                'project_end_date' => new Carbon('2017-09-01'),
            ],
            [
                'name' => 'Projet 7',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2018-01-01'),
                'project_end_date' => new Carbon('2018-09-01'),
            ],
            [
                'name' => 'Projet 8',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2019-01-01'),
                'project_end_date' => new Carbon('2021-09-01'),
            ],
            [
                'name' => 'Projet 9',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2021-01-01'),
                'project_end_date' => new Carbon('2022-09-01'),
            ],
            [
                'name' => 'Projet 10',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2022-01-01'),
                'project_end_date' => new Carbon('2023-09-01'),
            ],
            [
                'name' => 'Projet 11',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2021-01-01'),
                'project_end_date' => new Carbon('2022-09-01'),
            ],
            [
                'name' => 'Projet 12',
                'slug' => 'placeholder',
                'project_start_date' => new Carbon('2021-01-01'),
                'project_end_date' => new Carbon('2022-09-01'),
            ]
        ];

        $yearGroupedProjects = [];
        foreach ($fakeProjects as $project) {
            $yearGroupedProjects[$project['project_start_date']->year][] = $project;
        }
        krsort($yearGroupedProjects);
        return view("projects", [
            'filters' => $filters,
            'yearGroupedProjects' => $yearGroupedProjects,
        ]);
    }
}
