<?php

namespace DanGreaves\GuzzleRunscope\Providers;

use Orchestra\Testbench\TestCase;
use DanGreaves\GuzzleRunscope\RequestTransformer;

class LaravelServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function request_transformer_resolved_with_key_from_config()
    {
        config(['services.runscope.bucketKey' => 'abc123']);

        $transformer = $this->app->make(RequestTransformer::class);

        $this->assertEquals('abc123', $transformer->getBucketKey());
    }

    /**
     * @test
     */
    public function request_transformer_resolved_with_key_from_params()
    {
        $transformer = $this->app->makeWith(RequestTransformer::class, ['bucketKey' => 'abc123']);

        $this->assertEquals('abc123', $transformer->getBucketKey());
    }

    /**
     * @test
     * @expectedException \DomainException
     * @expectedExceptionMessage You have not defined a Runscope bucket key
     */
    public function request_transformer_throws_exception_without_key()
    {
        $this->app->make(RequestTransformer::class);
    }

    protected function getPackageProviders($app)
    {
        return [LaravelServiceProvider::class];
    }
}