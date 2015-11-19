<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Handler\StreamHandler;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
class Guzzle6StreamHttpAdapterTest extends Guzzle6HttpAdapterTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHandler()
    {
        return new StreamHandler();
    }
}
