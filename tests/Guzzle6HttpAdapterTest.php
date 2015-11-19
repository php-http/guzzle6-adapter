<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Client;
use Http\Adapter\Guzzle6HttpAdapter;
use Http\Client\Tests\HttpClientTest;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class Guzzle6HttpAdapterTest extends HttpClientTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHttpAdapter()
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
