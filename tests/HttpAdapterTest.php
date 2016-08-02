<?php

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client;
use Http\Client\Tests\HttpClientTest;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class HttpAdapterTest extends HttpClientTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHttpAdapter()
    {
        return new Client(new GuzzleClient(['handler' => $this->createHandler()]));
    }

    /**
     * Returns a handler for the client.
     *
     * @return object
     */
    abstract protected function createHandler();
}
