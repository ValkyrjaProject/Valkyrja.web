<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LayoutTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMainLayout()
    {
        $response = $this->get('/');

        // Header
        $response->assertSee('<div id="collapsingNavbar" class="collapse navbar-toggleable-sm">');

        // Footer copyright
        $response->assertSee('<div class="copyright">© '.(date("Y") === '2016' ? '2016' : '2016-'.date("Y")).' Rhea & SpyTec</div>');
    }
}
