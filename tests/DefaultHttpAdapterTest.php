<?php

declare(strict_types=1);

namespace Http\Adapter\Guzzle6\Tests;

use Http\Adapter\Guzzle6\Client;
use Http\Client\Tests\HttpClientTest;
use Psr\Http\Client\ClientInterface;

/**
 * @author David Buchmann <mail@davidbu.ch>
 */
class DefaultHttpAdapterTest extends HttpClientTest
{
    /**
     * {@inheritdoc}
     */
    protected function createHttpAdapter(): ClientInterface
    {
        return new Client();
    }
}
