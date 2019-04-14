<?php

namespace App\Services;

use App\ValueObjects\VideoData;

class GlorfFeedService extends BaseFeedService
{
    public function __construct() {
        parent::__construct('glorf');
    }

    public function parseFeed($sourceFormat)
    {
        echo "glorf.parse\n";

        return [
            new VideoData('dogs eat dogs', 'http://glorf2.com/videos/99.avi', [ 'nature', 'cruel', 'surviving' ]),
        ];

        // TODO: Implement parseFeed() method.
    }

    function downloadVideo(VideoData $video)
    {
        echo "glorf.download\n";
        // TODO: Implement downloadVideo() method.
    }

    function save(VideoData $video)
    {
        echo "glorf.save\n";
        // TODO: Implement save() method.
    }
}