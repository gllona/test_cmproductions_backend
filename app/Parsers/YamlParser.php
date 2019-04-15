<?php

namespace App\Parsers;

use App\ValueObjects\VideoData;
use Symfony\Component\Yaml\Yaml;

class YamlParser
{
    public function parse($rawData)
    {
        $json = $this->parseYaml($rawData);
        $videos = $this->buildList($json);

        return $videos;
    }

    private function parseYaml($rawData) {
        return Yaml::parse($rawData);
    }

    private function buildList($rawVideos) {
        $videos = array();

        foreach ($rawVideos as $rawVideo) {
            $videos[] = new VideoData(
                $rawVideo['name'],
                $rawVideo['url'],
                isset($rawVideo['labels']) ? preg_split(' *, *', $rawVideo['labels']) : array()
            );
        }

        return $videos;
    }
}