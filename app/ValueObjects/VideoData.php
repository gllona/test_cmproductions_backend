<?php

namespace App\ValueObjects;

class VideoData
{
    private $name;
    private $url;
    private $localFile;
    private $tags;

    public function __construct($name, $url, $tags)
    {
        $this->name = $name;
        $this->url = $url;
        $this->tags = $tags;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function getLocalFile()
    {
        return $this->localFile;
    }

    public function setLocalFile($localFile): void
    {
        $this->localFile = $localFile;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags): void
    {
        $this->tags = $tags;
    }
}