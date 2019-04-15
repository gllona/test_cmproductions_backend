<?php

namespace Tests\Unit;

use App\Exceptions\BadFormatException;
use App\Parsers\YamlParser;
use App\ValueObjects\VideoData;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class YamlParserTest extends TestCase
{
    private $parser;

    private $correctYamlFeed = <<<END
---
- 
  labels: animals, tech, wireless, tails
  name: "mouses run out of battery"
  url: "http://glorf.com/videos/external/mouses-run-out"
- 
  name: "keyboards should make noise"
  url: "http://glorf.com/videos/external/keyboards-should-make"
END;

    private function correctVideoDataArray() {
        return
            [
                new VideoData(
                    "mouses run out of battery",
                    "http://glorf.com/videos/external/mouses-run-out",
                    [ "animals", "tech", "wireless", "tails" ]
                ),
                new VideoData(
                    "keyboards should make noise",
                    "http://glorf.com/videos/external/keyboards-should-make",
                    []
                )
            ];
    }

    private $incorrectYamlFeedNoUrlField = <<<END
---
- 
  name_bad_field_name: "abcd"
  url: "ABCD"
END;

    private $incorrectYamlFeedNoTitleField = <<<END
---
- 
  name: "efgh"
  url_bad_field_name: "EFGH"
END;

    protected function setUp(): void {
        $this->parser = resolve(YamlParser::class);
    }

    public function testParseOk()
    {
        $this->assertEquals($this->correctVideoDataArray(), $this->parser->parse($this->correctYamlFeed));
    }

    /**
     * @expectedException App\Exceptions\BadFormatException
     */
    public function testIncorrectJsonFormatNoUrlField()
    {
        $videos = $this->parser->parse($this->incorrectYamlFeedNoUrlField);
    }

    /**
     * @expectedException App\Exceptions\BadFormatException
     */
    public function testIncorrectJsonFormatNoTitleField()
    {
        $videos = $this->parser->parse($this->incorrectYamlFeedNoTitleField);
    }
}
