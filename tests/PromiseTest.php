<?php

namespace Tests\Http\Adapter\Guzzle6;

use GuzzleHttp\Promise\RejectedPromise;
use Http\Adapter\Guzzle6\Promise;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class PromiseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @test
     */
    public function it_handles_non_domain_exception()
    {
        $request = $this->prophesize('Psr\Http\Message\RequestInterface');
        $promise = new RejectedPromise(new \Exception());

        $guzzlePromise = new Promise($promise, $request->reveal());

        $guzzlePromise->wait();
    }
}
