<?php

namespace DanGreaves\GuzzleRunscope\Providers;

use Illuminate\Support\ServiceProvider;
use DanGreaves\GuzzleRunscope\Deciders;
use DanGreaves\GuzzleRunscope\Contracts;
use DanGreaves\GuzzleRunscope\MiddlewareFactory;
use DanGreaves\GuzzleRunscope\RequestTransformer;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RequestTransformer::class, function ($app, $params) {

            if (! $bucketKey = array_get($params, 'bucketKey', config('services.runscope.bucketKey'))) {
                throw new \DomainException('You have not defined a Runscope bucket key');
            }

            return new RequestTransformer($bucketKey);

        });

        $this->app->bind(Contracts\Decider::class, Deciders\AlwaysDecider::class);

        $this->app->bind(MiddlewareFactory::class, function ($app, $params) {

            return (new MiddlewareFactory(
                $app->makeWith(RequestTransformer::class, $params),
                $app->make(Contracts\Decider::class)
            ))->make();

        });
    }
}