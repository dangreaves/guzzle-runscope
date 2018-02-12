<?php

namespace DanGreaves\GuzzleRunscope;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class RequestTransformerTest extends TestCase
{
    /**
     * @test
     */
    public function hostname_is_updated_correctly()
    {
        $request = (new RequestTransformer('abc123'))->transform(
            new Request('GET', 'https://example.com/foo/bar')
        );

        $this->assertEquals('example-com-abc123.runscope.net', $request->geturi()->getHost());
    }

    /**
     * @test
     */
    public function hostname_with_dashes_is_updated_correctly()
    {
        $request = (new RequestTransformer('abc123'))->transform(
            new Request('GET', 'https://example-two.com/foo/bar')
        );

        $this->assertEquals('example--two-com-abc123.runscope.net', $request->geturi()->getHost());
    }
}