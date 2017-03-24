<?php

namespace Tests\Http\Adapter\Guzzle6;

use GuzzleHttp\Handler\StreamHandler;

/**
 * @author Joel Wurtz <joel.wurtz@gmail.com>
 */
class StreamHttpAsyncAdapterTest extends HttpAsyncAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new StreamHandler();
    }
}
