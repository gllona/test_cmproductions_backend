<?php

namespace App\Registries;

use App\Exceptions\UnknownFeedException;

class BaseRegistry
{
    private $registry = array();

    public function register($feedName, $class) {
        $this->registry[$feedName] = $class;
    }

    public function get($feedName) {
        if (isset($this->registry[$feedName])) {
            return resolve($this->registry[$feedName]);
        } else {
            throw new UnknownFeedException("Feed source ${feedName} not registered");
        }
    }
}