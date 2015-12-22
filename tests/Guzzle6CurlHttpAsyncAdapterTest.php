<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Handler\CurlHandler;

/**
 * @requires PHP 5.5
 *
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class Guzzle6CurlHttpAsyncAdapterTest extends Guzzle6HttpAsyncAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlHandler();
    }
}
