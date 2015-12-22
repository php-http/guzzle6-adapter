<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Handler\CurlMultiHandler;

/**
 * @author Joel Wurtz <joel.wurtz@gmail.com>
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
