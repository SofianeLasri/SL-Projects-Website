<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
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
            if (! empty($category['url'])) {
                // Si != # ou ne démarre pas par http, on va tester que la route existe
                if (! Str::startsWith($category['url'], '#') && ! Str::startsWith($category['url'], 'http')) {
                    $this->assertNotNull(route($category['url']), 'Route inexistante');
                }
            }
            foreach ($category['children'] as $child) {
                $this->assertArrayHasKey('title', $child, 'Enfant sans titre');

                if (! empty($child['url'])) {
                    // Si != # ou ne démarre pas par http, on va tester que la route existe
                    if (! Str::startsWith($child['url'], '#') && ! Str::startsWith($child['url'], 'http')) {
                        $this->assertNotNull(route($child['url']), 'Route inexistante');
                    }
                }

                // Si le groupe de liens existe
                if (array_key_exists('links', $child)) {
                    $this->assertNotEmpty($child['links'], 'Groupe de liens sans enfants');
                    foreach ($child['links'] as $link) {
                        $this->assertArrayHasKey('title', $link, 'Lien sans titre');

                        if (! empty($link['url'])) {
                            // Si != # ou ne démarre pas par http, on va tester que la route existe
                            if (! Str::startsWith($link['url'], '#') && ! Str::startsWith($link['url'], 'http')) {
                                $this->assertNotNull(route($link['url']), 'Route inexistante');
                            }
                        }
                    }
                }
            }
        }
    }
}
