<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DashboardNavigationLinksConfigStructuralTest extends TestCase
{
    /** @test */
    public function checkNavigationConfigStructure(): void
    {
        $navigation = config('dashboard.navigation');
        $ids = [];

        foreach ($navigation as $item) {
            // Check required fields
            $this->assertNotEmpty($item['id']);
            $this->assertIsString($item['id']);
            $this->assertNotEmpty($item['title']);
            $this->assertIsString($item['title']);
            $this->assertNotEmpty($item['description']);
            $this->assertIsString($item['description']);

            // Check unique ID
            $this->assertNotContains($item['id'], $ids);
            $ids[] = $item['id'];

            // Check if route exists
            if (isset($item['route'])) {
                $this->assertTrue(Route::has($item['route']));
            }

            // Check if parent exists
            if (isset($item['parent'])) {
                $this->assertContains($item['parent'], $ids);
            }
        }
    }
}
