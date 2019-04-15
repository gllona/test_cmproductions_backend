<?php

namespace App\Contracts;

use App\ValueObjects\VideoData;

interface Repository
{
    function save(VideoData $video);
}