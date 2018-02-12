<?php

namespace DanGreaves\GuzzleRunscope;

use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

class MiddlewareFactory
{
    /**
     * Request transformer.
     *
     * @var string
     */
    protected $transformer;

    /**
     * Decider.
     *
     * @var Contracts\Decider
     */
    protected $decider;

    /**
     * MiddlewareFactory constructor.
     *
     * @param RequestTransformer $transformer
     * @param Contracts\Decider  $decider
     */
    public function __construct(RequestTransformer $transformer, Contracts\Decider $decider = null)
    {
        $this->transformer = $transformer;
        $this->decider     = $decider ?: new Deciders\AlwaysDecider;
    }

    /**
     * Build middleware callable.
     *
     * @return callable
     */
    public function make()
    {
        return Middleware::mapRequest(function (RequestInterface $request) {

            if (! $this->decider->shouldReport($request)) {
                return $request;
            }

            return $this->transformer->transform($request);

        });
    }
}