<?php

namespace Tests\Http\Adapter\Guzzle6;

use GuzzleHttp\Handler\CurlMultiHandler;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class MultiCurlHttpAdapterTest extends HttpAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlMultiHandler();
    }
}
