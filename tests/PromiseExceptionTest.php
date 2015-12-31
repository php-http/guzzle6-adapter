<?php

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Exception as GuzzleExceptions;
use Http\Adapter\Guzzle6\Promise;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class PromiseExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetException()
    {
        $request = $this->getMock('Psr\Http\Message\RequestInterface');
        $response = $this->getMock('Psr\Http\Message\ResponseInterface');
        $promise = $this->getMock('GuzzleHttp\Promise\PromiseInterface');

        $adapter = new Promise($promise, $request);
        $method  = new \ReflectionMethod('Http\Adapter\Guzzle6\Promise', 'handleException');
        $method->setAccessible(true);

        $outputException = $method->invoke($adapter, new GuzzleExceptions\ConnectException('foo', $request), $request);
        $this->assertInstanceOf('Http\Client\Exception\NetworkException', $outputException, "Guzzle's ConnectException should be converted to a NetworkException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\TooManyRedirectsException('foo', $request), $request);
        $this->assertInstanceOf('Http\Client\Exception\RequestException', $outputException, "Guzzle's TooManyRedirectsException should be converted to a RequestException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\RequestException('foo', $request, $response), $request);
        $this->assertInstanceOf('Http\Client\Exception\HttpException', $outputException, "Guzzle's RequestException should be converted to a HttpException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\BadResponseException('foo', $request, $response), $request);
        $this->assertInstanceOf('Http\Client\Exception\HttpException', $outputException, "Guzzle's BadResponseException should be converted to a HttpException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\ClientException('foo', $request, $response), $request);
        $this->assertInstanceOf('Http\Client\Exception\HttpException', $outputException, "Guzzle's ClientException should be converted to a HttpException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\ServerException('foo', $request, $response), $request);
        $this->assertInstanceOf('Http\Client\Exception\HttpException', $outputException, "Guzzle's ServerException should be converted to a HttpException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\TransferException('foo'), $request);
        $this->assertInstanceOf('Http\Client\Exception\TransferException', $outputException, "Guzzle's TransferException should be converted to a TransferException");

        /*
         * Test RequestException without response
         */
        $outputException = $method->invoke($adapter, new GuzzleExceptions\RequestException('foo', $request), $request);
        $this->assertInstanceOf('Http\Client\Exception\RequestException', $outputException, "Guzzle's RequestException with no response should be converted to a RequestException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\BadResponseException('foo', $request), $request);
        $this->assertInstanceOf('Http\Client\Exception\RequestException', $outputException, "Guzzle's BadResponseException with no response should be converted to a RequestException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\ClientException('foo', $request), $request);
        $this->assertInstanceOf('Http\Client\Exception\RequestException', $outputException, "Guzzle's ClientException with no response should be converted to a RequestException");

        $outputException = $method->invoke($adapter, new GuzzleExceptions\ServerException('foo', $request), $request);
        $this->assertInstanceOf('Http\Client\Exception\RequestException', $outputException, "Guzzle's ServerException with no response should be converted to a RequestException");
    }
}
