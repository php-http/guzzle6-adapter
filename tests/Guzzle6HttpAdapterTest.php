<?php

/*
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Http\Adapter\Tests;

use GuzzleHttp\Client;
use Http\Adapter\Guzzle6HttpAdapter;

/**
 * @author GeLo <geloen.eric@gmail.com>
 */
abstract class Guzzle6HttpAdapterTest extends HttpAdapterTest
{
    public function testGetName()
    {
        $this->assertSame('guzzle6', $this->httpAdapter->getName());
    }

    /**
     * {@inheritdoc}
     */
    protected function createHttpAdapter()
    {
        return new Guzzle6HttpAdapter(new Client(['handler' => $this->createHandler()]));
    }

    /**
     * Returns a handler for the client
     *
     * @return object
     */
    abstract protected function createHandler();
}
