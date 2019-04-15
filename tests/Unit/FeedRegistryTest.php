<?php

namespace Tests\Unit;

use App\Exceptions\UnknownEntryException;
use App\Registries\FeedsRegistry;
use App\Services\GlorfFeedService;
use stdClass;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedRegistryTest extends TestCase
{
    private $registry;

    protected function setUp(): void {
        $this->registry = resolve(FeedsRegistry::class);
        $this->registry->reset();
    }

    public function testRegisterOk() {
        $this->registry->register('bar', GlorfFeedService::class);

        $object = $this->registry->get('bar');

        $this->assertInstanceOf(GlorfFeedService::class, $object);
    }

    /**
     * @expectedException App\Exceptions\UnknownEntryException
     */
    public function testNoStrangeElementFound() {
        $this->registry->get('not_registered_element');
    }
}
