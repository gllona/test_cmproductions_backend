<?php

namespace App\Parsers;

use App\Contracts\Parser;
use App\Exceptions\BadFormatException;
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
        $json = json_decode($rawData);

        if ($json === null) {
            throw new BadFormatException('Json parse error with: "' . substr($rawData, 0, 40) . '..."');
        }

        return $json;
    }

    private function buildList($rawVideos) {
        $videos = array();

        foreach ($rawVideos->videos as $rawVideo) {
            if (! isset($rawVideo->title) || ! isset($rawVideo->url)) {
                throw new BadFormatException('incomplete fields');
            }

            $videos[] = new VideoData(
                $rawVideo->title,
                $rawVideo->url,
                isset($rawVideo->tags) ? $rawVideo->tags : array()
            );
        }

        return $videos;
    }
}