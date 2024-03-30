<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser) {
            echo route('showcase.home');
            $browser->visit(route('showcase.home'))
                ->assertSee('Sofiane Lasri');
        });
    }
}
