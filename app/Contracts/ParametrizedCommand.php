<?php

namespace App\Contracts;

use Illuminate\Console\Command;

abstract class ParametrizedCommand extends Command
{
    public abstract function verbose();
}