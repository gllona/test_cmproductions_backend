<?php

namespace Tests\Unit;

use App\Exceptions\BadFormatException;
use App\Parsers\JsonParser;
use App\ValueObjects\VideoData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JsonParserTest extends TestCase
{
    private $parser;

    private $correctJsonFeed = <<<END
        {
            "videos": [
                {
                    "tags": [
                        "words",
                        "lies",
                        "truths"
                    ],
                    "url": "http://glorf.com/external/videos/a-foreigner-told",
                    "title": "A foreigner told them that"
                },
                {
                    "url": "http://glorf.com/external/videos/no-tags-for",
                    "title": "No tags for the warriors"
                }
            ]
        }
END;

    private function correctVideoDataArray() {
        return
            [
                new VideoData(
                    "A foreigner told them that",
                    "http://glorf.com/external/videos/a-foreigner-told",
                    [ "words", "lies", "truths" ]
                ),
                new VideoData(
                    "No tags for the warriors",
                    "http://glorf.com/external/videos/no-tags-for",
                    []
                )
            ];
    }

    private $incorrectJsonFeedNoUrlField = <<<END
        {
            "videos": [
                {
                    "url_bad_field_name": "abcd",
                    "title": "ABCD"
                }
            ]
        }
END;

    private $incorrectJsonFeedNoTitleField = <<<END
        {
            "videos": [
                {
                    "url": "efgh",
                    "title_bad_field_name": "EFGH"
                }
            ]
        }
END;

    protected function setUp(): void {
        $this->parser = resolve(JsonParser::class);
    }

    public function testParseOk()
    {
        $this->assertEquals($this->correctVideoDataArray(), $this->parser->parse($this->correctJsonFeed));
    }

    /**
     * @expectedException App\Exceptions\BadFormatException
     */
    public function testIncorrectJsonFormatNoUrlField()
    {
        $videos = $this->parser->parse($this->incorrectJsonFeedNoUrlField);
    }

    /**
     * @expectedException App\Exceptions\BadFormatException
     */
    public function testIncorrectJsonFormatNoTitleField()
    {
        $videos = $this->parser->parse($this->incorrectJsonFeedNoTitleField);
    }
}
