<?php

namespace Tests\Unit;

use App\Parsers\YamlParser;
use App\Services\FlubFeedService;
use App\ValueObjects\VideoData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlubFeedServiceTest extends TestCase
{
    private function videoListOk() {
        return
            [
                new VideoData(
                    "the movie of numbers",
                    "http://glorf.com/external/videos/numbers",
                    [ "1", "2", "3" ]
                )
            ];
    }

    public function testProcessFeedOk() {
        $this->mock(YamlParser::class, function ($mock) {
            $mock->shouldReceive('parse')
                ->once()
                ->andReturn($this->videoListOk());
        });

        $service = resolve(FlubFeedService::class);
        $videos = $service->parseFeed('json');

        $this->assertEquals($this->videoListOk(), $videos);
    }
}
