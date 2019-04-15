<?php

namespace Tests\Unit;

use App\Parsers\JsonParser;
use App\Services\GlorfFeedService;
use App\ValueObjects\VideoData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GlorfFeedServiceTest extends TestCase
{
    private function videoListOk() {
        return
            [
                new VideoData(
                    "The spy and the voter",
                    "http://glorf.com/external/videos/the-spy-and",
                    [ "thriller", "correctness", "drama" ]
                ),
                new VideoData(
                    "Dirty characters",
                    "http://glorf.com/external/videos/dirty-characters",
                    []
                )
            ];
    }

    public function testProcessFeedOk() {
        $this->mock(JsonParser::class, function ($mock) {
            $mock->shouldReceive('parse')
                ->once()
                ->andReturn($this->videoListOk());
        });

        $service = resolve(GlorfFeedService::class);
        $videos = $service->parseFeed('json');

        $this->assertEquals($this->videoListOk(), $videos);
    }
}
