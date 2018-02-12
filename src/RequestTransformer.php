<?php

namespace DanGreaves\GuzzleRunscope;

use Psr\Http\Message\RequestInterface;

class RequestTransformer
{
    /**
     * Runscope bucket key.
     *
     * @var string
     */
    protected $bucketKey;

    /**
     * RequestTransformer constructor.
     *
     * @param string $bucketKey
     */
    public function __construct($bucketKey)
    {
        $this->bucketKey = $bucketKey;
    }

    /**
     * Get Runscope bucket key.
     *
     * @return string
     */
    public function getBucketKey()
    {
        return $this->bucketKey;
    }

    /**
     * Transform the given request.
     *
     * @param  RequestInterface $request
     * @return RequestInterface
     */
    public function transform(RequestInterface $request)
    {
        $host = $request->getUri()->getHost();

        $host = str_replace('-', '--', $host);
        $host = str_replace('.', '-', $host);

        $host = sprintf('%s-%s.%s', $host, $this->bucketKey, 'runscope.net');

        return $request->withUri(
            $request->getUri()->withHost($host)
        );
    }
}