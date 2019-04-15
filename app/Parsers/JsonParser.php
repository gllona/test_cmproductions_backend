<?php

namespace App\Parsers;

use App\Contracts\Parser;
use App\ValueObjects\VideoData;

class JsonParser implements Parser
{
    public function parse($rawData)
    {
        $json = $this->parseJson($rawData);
        $videos = $this->buildList($json);

        return $videos;
    }

    private function parseJson($rawData) {
        return json_decode($rawData);
    }

    private function buildList($rawVideos) {
        $videos = array();

        foreach ($rawVideos->videos as $rawVideo) {
            $videos[] = new VideoData(
                $rawVideo->title,
                $rawVideo->url,
                isset($rawVideo->tags) ? $rawVideo->tags : array()
            );
        }

        return $videos;
    }
}