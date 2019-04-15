<?php

namespace App\Providers;

use App\Contracts\Parser;
use App\Contracts\Repository;
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
    public $singletons = [
        FeedsRegistry::class => FeedsRegistry::class,
        ParsersRegistry::class => ParsersRegistry::class,
        RepositoriesRegistry::class => RepositoriesRegistry::class,
        JsonParser::class => JsonParser::class,
        YamlParser::class => YamlParser::class,
        MysqlRepository::class => MysqlRepository::class,
        CassandraRepository::class => CassandraRepository::class,
        GlorfFeedService::class => GlorfFeedService::class,
        FlubFeedService::class => FlubFeedService::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //TODO delete lines
        //$this->app->singleton(FeedsRegistry::class, function($app) {
        //    return new FeedsRegistry();
        //});
        //
        //$this->app->singleton(ParsersRegistry::class, function($app) {
        //    return new ParsersRegistry();
        //});
        //
        //$this->app->singleton(RepositoriesRegistry::class, function($app) {
        //    return new RepositoriesRegistry();
        //});

        //TODO check if let this wired
        $this->app->when(GlorfFeedService::class)
            ->needs(Parser::class)
            ->give(function () {
                return resolve(JsonParser::class);
            });

        $this->app->when(FlubFeedService::class)
            ->needs(Parser::class)
            ->give(function () {
                return resolve(YamlParser::class);
            });

        $this->app->when(GlorfFeedService::class)
            ->needs(Repository::class)
            ->give(function () {
                return resolve(MysqlRepository::class);
            });

        $this->app->when(FlubFeedService::class)
            ->needs(Repository::class)
            ->give(function () {
                return resolve(MysqlRepository::class);
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
        $registry = resolve(FeedsRegistry::class);

        $registry->register(config('feed.glorf.id'), GlorfFeedService::class);
        $registry->register(config('feed.flub.id'), FlubFeedService::class);
    }

    private function registerParsers() {
        $registry = resolve(ParsersRegistry::class);

        $registry->register('json', JsonParser::class);
        $registry->register('yaml', YamlParser::class);
    }

    private function registerRepositories() {
        $registry = resolve(RepositoriesRegistry::class);

        $registry->register('mysql', MysqlRepository::class);
        $registry->register('cassandra', CassandraRepository::class);
    }
}
