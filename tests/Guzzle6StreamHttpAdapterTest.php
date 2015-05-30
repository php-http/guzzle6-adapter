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
