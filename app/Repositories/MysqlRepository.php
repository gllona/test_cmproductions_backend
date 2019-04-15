<?php

namespace App\Repositories;

use App\Contracts\Repository;
use App\ValueObjects\VideoData;

class MysqlRepository implements Repository
{
    public function save(VideoData $video)
    {
        $this->saveToFs($video);
        $this->saveToDb($video);
    }

    private function saveToFs(VideoData $video) {
        //TODO move downloaded file to final server/location
    }

    private function saveToDb(VideoData $video) {
        //TODO save columnar data in MySql database
    }
}