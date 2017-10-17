<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaticPagesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomePage()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Botwinder - The Discord Bot');
        $response->assertSee('href="//status.botwinder.info"');
    }

    public function testDocsPage()
    {
        $response = $this->get('/features');
        $response->assertStatus(301);

        $response = $this->get('/docs');
        $response->assertStatus(200);
        $response->assertSeeText('These are some features that are not fully covered by simple commands');
        $response->assertSee('<h1 class="features-h1">Commands ~ Basic</h1>');
    }

    public function testInvitePage()
    {
        $response = $this->get('/invite');
        $response->assertStatus(200);
        $response->assertSee('<button class="btn btn-primary">Invite</button>');
    }

    public function testUpdatesPage()
    {
        $response = $this->get('/updates');
        $response->assertStatus(200);

        $response->assertSeeText('Upcoming features');
        $response->assertSeeText('Changelog');
    }

    public function testHelpPage()
    {
        $response = $this->get('/help');
        $response->assertStatus(200);

        $response->assertSee('<a href="http://support.botwinder.info" target="_blank">our Discord server</a>');
    }

    public function testTeamPage()
    {
        $response = $this->get('/team');
        $response->assertStatus(200);
    }
}
