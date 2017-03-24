<?php

namespace Tests\Http\Adapter\Guzzle6;

use GuzzleHttp\Handler\CurlMultiHandler;

/**
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class MultiCurlHttpAsyncAdapterTest extends HttpAsyncAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new CurlMultiHandler();
    }
}
