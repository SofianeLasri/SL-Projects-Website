<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DashboardNavigationLinksConfigStructuralTest extends TestCase
{
    public function testBasic()
    {
        $navigation = config('dashboard.navigation');
        $this->checkNodeStructure($navigation);
    }

    private function checkNodeStructure(array $node): void
    {
        foreach ($node as $index => $item) {
            // Vérifie les attributs obligatoires
            $this->assertIsString($item['title']);
            $this->assertIsString($item['description']);
            $this->assertNotNull($item['title']);
            $this->assertNotNull($item['description']);

            // Vérifie la route si elle est présente
            if (isset($item['route'])) {
                $this->assertTrue(Route::has($item['route']), "Route {$item['route']} does not exist.");
            }

            // Vérifie les enfants si présents
            if (isset($item['children'])) {
                $this->checkNodeStructure($item['children']);
            }
        }
    }
}
