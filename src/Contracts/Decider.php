<?php

namespace DanGreaves\GuzzleRunscope\Contracts;

use Psr\Http\Message\RequestInterface;

interface Decider
{
    /**
     * Return true if the given request should be reported to Runscope.
     *
     * @param  RequestInterface $request
     * @return boolean
     */
    public function shouldReport(RequestInterface $request);
}