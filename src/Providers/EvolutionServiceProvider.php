<?php
namespace EvolutionPHP\Providers;

use Illuminate\Support\ServiceProvider;
use EvolutionPHP\EvolutionClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

class EvolutionServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->app->singleton(EvolutionClient::class, function ($app) {
            return new EvolutionClient(
                baseUrl: config('evolution.base_url'),
                apiKey: config('evolution.api_key'),
                httpClient: new Client(),
                requestFactory: new HttpFactory()
            );
        });
    }
}