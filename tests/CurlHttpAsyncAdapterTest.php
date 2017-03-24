<?php

namespace Tests\Http\Adapter\Guzzle6;

use GuzzleHttp\Handler\CurlHandler;

/**
 * @requires PHP 5.5
 *
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
