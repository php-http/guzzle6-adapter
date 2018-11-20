<?php

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Handler\CurlHandler;

/**
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class CurlHttpAsyncAdapterTest extends HttpAsyncAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlHandler();
    }
}
