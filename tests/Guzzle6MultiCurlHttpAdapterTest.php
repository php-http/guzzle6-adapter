<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Handler\CurlMultiHandler;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Guzzle6MultiCurlHttpAdapterTest extends Guzzle6HttpAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlMultiHandler();
    }
}
