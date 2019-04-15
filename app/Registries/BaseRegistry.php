<?php

namespace App\Registries;

use App\Exceptions\UnknownEntryException;

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
            throw new UnknownEntryException("Registry entry ${feedName} not registered");
        }
    }

    public function reset() {
        $this->registry = array();
    }
}