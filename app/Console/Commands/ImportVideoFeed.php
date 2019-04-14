<?php

namespace App\Console\Commands;

use App\Contracts\FeedService;
use App\Contracts\ParametrizedCommand;
use App\Registries\FeedsRegistry;
use Illuminate\Support\Facades\App;

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

        /** @var FeedService $service */
        $service = App::make(FeedsRegistry::class)->get($source);

        $service->processFeed($this);
    }

    public function verbose()
    {
        return $this->option('details') === true;
    }
}
