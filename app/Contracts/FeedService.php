<?php
namespace App\Contracts;

use App\ValueObjects\VideoData;
use Illuminate\Console\Command;

interface FeedService
{
    function processFeed(ParametrizedCommand $command);

    function parseFeed($sourceFormat);

    function downloadVideo(VideoData $video);

    function save(VideoData $video);
}