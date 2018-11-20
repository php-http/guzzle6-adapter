<?php

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Handler\CurlHandler;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class CurlHttpAdapterTest extends HttpAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlHandler();
    }
}
