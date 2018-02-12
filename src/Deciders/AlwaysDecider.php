<?php

namespace DanGreaves\GuzzleRunscope\Deciders;

use Psr\Http\Message\RequestInterface;
use DanGreaves\GuzzleRunscope\Contracts;

class AlwaysDecider implements Contracts\Decider
{
    /**
     * Return true if the given request should be reported to Runscope.
     *
     * @param  RequestInterface $request
     * @return boolean
     */
    public function shouldReport(RequestInterface $request)
    {
        return true;
    }
}