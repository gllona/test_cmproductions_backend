<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandTest extends TestCase
{
    public function testGlorf() {
        $this->artisan('videofeed:import glorf')
            ->expectsOutput('importing "The spy and the voter"; url: http://glorf.com/external/videos/the-spy-and; tags: [thriller, correctness, drama]')
            ->expectsOutput('importing "Dirty characters"; url: http://glorf.com/external/videos/dirty-characters; tags: []')
            ->assertExitCode(0);
    }

    public function testFlub() {
        $this->artisan('videofeed:import flub')
            ->expectsOutput('importing "the movie of numbers"; url: http://glorf.com/external/video/numbers; tags: [1, 2, 3]')
            ->assertExitCode(0);
    }

    public function testBadSource() {
        $this->artisan('videofeed:import unimplemented_source')
            ->expectsOutput('An error occured while processing command: Registry entry unimplemented_source not registered');
    }
}
