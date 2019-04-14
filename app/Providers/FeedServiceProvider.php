<?php

namespace App\Providers;

use App\Parsers\JsonParser;
use App\Parsers\YamlParser;
use App\Registries\FeedsRegistry;
use App\Registries\ParsersRegistry;
use App\Registries\RepositoriesRegistry;
use App\Repositories\CassandraRepository;
use App\Repositories\MysqlRepository;
use App\Services\FlubFeedService;
use App\Services\GlorfFeedService;
use Illuminate\Support\ServiceProvider;

class FeedServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FeedsRegistry::class, function($app) {
            return new FeedsRegistry();
        });

        $this->app->singleton(ParsersRegistry::class, function($app) {
            return new ParsersRegistry();
        });

        $this->app->singleton(RepositoriesRegistry::class, function($app) {
            return new RepositoriesRegistry();
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerServices();
        $this->registerParsers();
        $this->registerRepositories();
    }

    private function registerServices() {
        $registry = $this->app->make(FeedsRegistry::class);

        $registry->register(config('feed.glorf.id'), new GlorfFeedService());
        $registry->register(config('feed.flub.id'), new FlubFeedService());
    }

    private function registerParsers() {
        $registry = $this->app->make(ParsersRegistry::class);

        $registry->register('json', new JsonParser());
        $registry->register('yaml', new YamlParser());
    }

    private function registerRepositories() {
        $registry = $this->app->make(RepositoriesRegistry::class);

        $registry->register('mysql', new MysqlRepository());
        $registry->register('cassandra', new CassandraRepository());
    }
}
