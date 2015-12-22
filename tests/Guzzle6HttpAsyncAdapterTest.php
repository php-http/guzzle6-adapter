<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Client;
use Http\Adapter\Guzzle6HttpAdapter;
use Http\Client\Tests\HttpAsyncClientTest;

/**
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
abstract class Guzzle6HttpAsyncAdapterTest extends HttpAsyncClientTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHttpAsyncClient()
    {
        return new Guzzle6HttpAdapter(new Client(['handler' => $this->createHandler()]));
    }

    /**
     * Returns a handler for the client
     *
     * @return object
     */
    abstract protected function createHandler();
}
