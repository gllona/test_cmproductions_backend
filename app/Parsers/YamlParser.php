<?php

namespace App\Parsers;

use App\Exceptions\BadFormatException;
use App\ValueObjects\VideoData;
use Symfony\Component\Yaml\Exception\ParseException;
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
        try {
            $yaml = Yaml::parse($rawData);
        } catch (ParseException $e) {
            throw new BadFormatException('Yaml parse error with: "' . substr($rawData, 0, 40) . '..."');
        }

        return $yaml;
    }

    private function buildList($rawVideos) {
        $videos = array();

        foreach ($rawVideos as $rawVideo) {
            if (! isset($rawVideo['name']) || ! isset($rawVideo['url'])) {
                throw new BadFormatException('incomplete fields');
            }

            $videos[] = new VideoData(
                $rawVideo['name'],
                $rawVideo['url'],
                isset($rawVideo['labels']) ? preg_split(' *, *', $rawVideo['labels']) : array()
            );
        }

        return $videos;
    }
}