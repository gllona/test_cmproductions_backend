<?php

namespace App\Registries;

use App\Exceptions\UnknownFeedException;

class BaseRegistry
{
    private $registry = array();

    public function register($feedName, $provider) {
        $this->registry[$feedName] = $provider;
    }

    public function get($feedName) {
        if (isset($this->registry[$feedName])) {
            return $this->registry[$feedName];
        } else {
            throw new UnknownFeedException("Source ${feedName} not implemented");
        }
    }
}