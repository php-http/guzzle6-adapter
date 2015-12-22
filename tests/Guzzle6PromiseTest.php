<?php

namespace Http\Adapter\Tests;

use GuzzleHttp\Exception as GuzzleExceptions;
use GuzzleHttp\Promise\RejectedPromise;
use Http\Adapter\Guzzle6Promise;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Guzzle6PromiseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testNonDomainExceptionIsHandled()
    {
        $request = $this->prophesize('Psr\Http\Message\RequestInterface');
        $promise = new RejectedPromise(new \Exception());

        $guzzlePromise = new Guzzle6Promise($promise, $request->reveal());

        $guzzlePromise->wait();
    }
}
