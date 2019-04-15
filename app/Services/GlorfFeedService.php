<?php

namespace App\Services;

use App\Contracts\Parser;
use App\Contracts\Repository;
use App\Parsers\JsonParser;
use App\Repositories\MysqlRepository;
use App\ValueObjects\VideoData;

class GlorfFeedService extends BaseFeedService
{
    public function __construct() {
        parent::__construct('glorf');
    }

    public function parseFeed($sourceFormat)
    {
        $rawData = file_get_contents(config('feed.glorf.source.file'));

        /** @var Parser $parser */
        $parser = resolve(JsonParser::class);   //TODO should be Parser::class
        $videos = $parser->parse($rawData);

        return $videos;
    }

    function downloadVideo(VideoData $video)
    {
        // TODO: Implement downloadVideo() method.
        // It is not implemented right now because glorf.com requires username/password
        $video->setLocalFile('local_file_path');
    }

    function save(VideoData $video)
    {
        /** @var Repository $repository */
        $repository = resolve(MysqlRepository::class);   //TODO should be Repository::class
        $repository->save($video);
    }
}