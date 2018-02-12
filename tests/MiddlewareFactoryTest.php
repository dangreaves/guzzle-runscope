<?php

namespace DanGreaves\GuzzleRunscope;

use GuzzleHttp;
use PHPUnit\Framework\TestCase;
use DanGreaves\GuzzleRunscope\Deciders;

class MiddlewareFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function middleware_is_applied()
    {
        $container = [];

        $history = GuzzleHttp\Middleware::history($container);

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response]);

        $handler = GuzzleHttp\HandlerStack::create($mock);

        $handler->push(
            (new MiddlewareFactory(
                new RequestTransformer('abc123')
            ))->make()
        );

        $handler->push($history);

        $client = new GuzzleHttp\Client(['handler' => $handler]);

        $client->get('https://example.bar.com/records');

        $this->assertEquals(
            'https://example-bar-com-abc123.runscope.net/records',
            (string) $container[0]['request']->getUri()
        );
    }

    /**
     * @test
     */
    public function middleware_is_not_applied_when_decider_negative()
    {
        $container = [];

        $history = GuzzleHttp\Middleware::history($container);

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response]);

        $handler = GuzzleHttp\HandlerStack::create($mock);

        $handler->push(
            (new MiddlewareFactory(
                new RequestTransformer('abc123'),
                new Deciders\NeverDecider
            ))->make()
        );

        $handler->push($history);

        $client = new GuzzleHttp\Client(['handler' => $handler]);

        $client->get('https://example.bar.com/records');

        $this->assertEquals(
            'https://example.bar.com/records',
            (string) $container[0]['request']->getUri()
        );
    }
}