<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Handler\StreamHandler;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Guzzle6StreamHttpAsyncAdapterTest extends Guzzle6HttpAsyncAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new StreamHandler();
    }
}
