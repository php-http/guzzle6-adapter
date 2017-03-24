<?php

namespace Tests\Http\Adapter\Guzzle6;

use GuzzleHttp\Handler\CurlHandler;

/**
 * @requires PHP 5.5
 *
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
