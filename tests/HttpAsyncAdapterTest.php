<?php

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client;
use Http\Client\Tests\HttpAsyncClientTest;

/**
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
abstract class HttpAsyncAdapterTest extends HttpAsyncClientTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHttpAsyncClient()
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
