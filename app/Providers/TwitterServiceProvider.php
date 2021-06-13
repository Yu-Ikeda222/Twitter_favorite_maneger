<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('twitter', function () {

            $config = config('twitter');

            return new TwitterOAuth($config['client_id'], $config['client_secret'], $config['access_token'], $config['access_token_secret'], $config['bearer_token'], $config['call_back_url']);

        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['twitter'];
    }
}