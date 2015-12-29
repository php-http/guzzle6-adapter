<?php

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Exception as GuzzleExceptions;
use GuzzleHttp\Promise\RejectedPromise;
use Http\Adapter\Guzzle6\Promise;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class PromiseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testNonDomainExceptionIsHandled()
    {
        $request = $this->prophesize('Psr\Http\Message\RequestInterface');
        $promise = new RejectedPromise(new \Exception());

        $guzzlePromise = new Promise($promise, $request->reveal());

        $guzzlePromise->wait();
    }
}
