<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Handler\CurlHandler;

/**
 * @requires PHP 5.5
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Guzzle6CurlHttpAdapterTest extends Guzzle6HttpAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlHandler();
    }
}
