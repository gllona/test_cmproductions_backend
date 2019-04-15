<?php

namespace App\Contracts;

use App\ValueObjects\VideoData;

interface Parser
{
    /**
     * @param string $rawData
     * @return VideoData[]
     */
    function parse($rawData);
}