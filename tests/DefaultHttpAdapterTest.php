<?php

namespace Http\Adapter\Guzzle6\Tests;

use Http\Adapter\Guzzle6\Client;
use Http\Client\Tests\HttpClientTest;

/**
 * @author David Buchmann <mail@davidbu.ch>
 */
class DefaultHttpAdapterTest extends HttpClientTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHttpAdapter()
    {
        return new Client();
    }
}
