<?php

declare(strict_types=1);

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Promise\RejectedPromise;
use Http\Adapter\Guzzle6\Promise;
use PHPUnit\Framework\TestCase;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class PromiseTest extends TestCase
{
    public function testNonDomainExceptionIsHandled()
    {
        $this->expectException(\Exception::class);

        $request = $this->prophesize('Psr\Http\Message\RequestInterface');
        $promise = new RejectedPromise(new \Exception());

        $guzzlePromise = new Promise($promise, $request->reveal());

        $guzzlePromise->wait();
    }
}
