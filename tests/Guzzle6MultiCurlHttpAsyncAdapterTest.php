<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Handler\CurlMultiHandler;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Guzzle6MultiCurlHttpAsyncAdapterTest extends Guzzle6HttpAsyncAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlMultiHandler();
    }
}
