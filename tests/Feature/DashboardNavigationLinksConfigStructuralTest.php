<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardNavigationLinksConfigStructuralTest extends TestCase
{
    /** @test */
    public function checkNavigationConfigStructure(): void
    {
        $navigationConfig = config('dashboard.navigation');
        foreach ($navigationConfig as $category) {
            $this->assertArrayHasKey('title', $category, 'Catégorie sans titre');
            $this->assertArrayHasKey('description', $category, 'Catégorie sans description');

            $this->assertArrayHasKey('children', $category, 'Catégorie sans enfants');
            foreach ($category['children'] as $child) {
                $this->assertArrayHasKey('title', $child, 'Enfant sans titre');

                // Si le groupe de liens existe
                if (array_key_exists('links', $child)) {
                    $this->assertNotEmpty($child['links'], 'Groupe de liens sans enfants');
                    foreach ($child['links'] as $link) {
                        $this->assertArrayHasKey('title', $link, 'Lien sans titre');
                    }
                }
            }
        }
    }
}
