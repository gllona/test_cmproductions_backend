<?php
namespace App\Services;

use App\Contracts\FeedService;
use App\Contracts\ParametrizedCommand;
use App\ValueObjects\VideoData;

abstract class BaseFeedService implements FeedService
{
    protected $id;
    protected $sourceFormat;
    protected $targetDb;

    protected function __construct($id) {
        $this->id = $id;
    }

    // IoC
    public function processFeed(ParametrizedCommand $command) {
        $videos = $this->parseFeed($this->sourceFormat);
        if ($command->verbose()) {
            $command->line('source feed parsed');
        }

        /** @var VideoData $video */
        foreach ($videos as $video) {
            $tags = implode(', ', $video->getTags());
            $command->line('importing "' . $video->getName() . '"; url: ' . $video->getUrl() . "; tags: [$tags]");

            $video->setLocalFile($this->downloadVideo($video));
            if ($command->verbose()) {
                $command->line('+-- video downloaded');
            }

            $this->save($video);
            if ($command->verbose()) {
                $command->line('+-- video data saved');
                $command->line('+-- imported!');
            }
        }
    }

    public abstract function parseFeed($sourceFormat);

    public abstract function downloadVideo(VideoData $video);

    public abstract function save(VideoData $video);
}