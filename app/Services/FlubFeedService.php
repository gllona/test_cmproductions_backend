<?php

namespace App\Services;

use App\ValueObjects\VideoData;

class FlubFeedService extends BaseFeedService
{
    public function __construct() {
        parent::__construct('flub');
    }

    public function parseFeed($sourceFormat)
    {
        // TODO: Implement parseFeed() method.
    }

    function downloadVideo(VideoData $video)
    {
        // TODO: Implement downloadVideo() method.
    }

    function save(VideoData $video)
    {
        // TODO: Implement save() method.
    }
}