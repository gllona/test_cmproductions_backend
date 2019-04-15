<?php

namespace App\Console\Commands;

use App\Contracts\FeedService;
use App\Contracts\ParametrizedCommand;
use App\Registries\FeedsRegistry;
use Exception;

class ImportVideoFeed extends ParametrizedCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'videofeed:import
                            {source : ID of the feed}
                            {--d|details}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a video feed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $source = $this->argument('source');

        try {
            /** @var FeedService $service */
            $service = resolve(FeedsRegistry::class)->get($source);
            $service->processFeed($this);
        } catch (Exception $e) {
            $this->error("An error occured while processing command: " . $e->getMessage());
        }
    }

    public function verbose()
    {
        return $this->option('details') === true;
    }
}
