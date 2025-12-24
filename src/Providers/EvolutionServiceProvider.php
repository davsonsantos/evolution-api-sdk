<?php

namespace EvolutionPHP\Providers;

use Illuminate\Support\ServiceProvider;
use EvolutionPHP\EvolutionClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class EvolutionServiceProvider extends ServiceProvider 
{
    /**
     * Register services.
     */
    public function register(): void 
    {
        $this->app->singleton(EvolutionClient::class, function ($app) {
            $config = $app['config'];

            // Forçamos a tipagem para satisfazer a PSR-17/18 e o Intelephense
            $httpClient = new GuzzleClient();
            $requestFactory = new HttpFactory();

            return new EvolutionClient(
                baseUrl: (string) $config->get('evolution.base_url', 'http://localhost:8080'),
                apiKey: (string) $config->get('evolution.api_key', ''),
                httpClient: $httpClient,
                requestFactory: $requestFactory
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/evolution.php' => config_path('evolution.php'),
            ], 'evolution-config');
        }
    }
}