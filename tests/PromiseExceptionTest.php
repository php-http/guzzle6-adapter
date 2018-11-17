<?php

declare(strict_types=1);

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Exception as GuzzleExceptions;
use GuzzleHttp\Promise\PromiseInterface;
use Http\Adapter\Guzzle6\Promise;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\Exception\RequestException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 * @author George Mponos <gmponos@gmail.com>
 */
final class PromiseExceptionTest extends TestCase
{
    /**
     * @var RequestInterface|MockObject
     */
    private $request;

    /**
     * @var ResponseInterface|MockObject
     */
    private $response;

    /**
     * @var PromiseInterface
     */
    private $promise;

    public function setUp()
    {
        parent::setUp();
        $this->request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $this->response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $this->promise = new \GuzzleHttp\Promise\Promise();
    }

    public function testThatNetworkExceptionIsThrownForGuzzleConnectionException()
    {
        $this->promise->reject(new GuzzleExceptions\ConnectException('foo', $this->request));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(NetworkException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatRequestExceptionIsThrownForGuzzleTooManyRedirectsException()
    {
        $this->promise->reject(new GuzzleExceptions\TooManyRedirectsException('foo', $this->request));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatHttpExceptionIsThrownForGuzzleRequestException()
    {
        $this->promise->reject(new GuzzleExceptions\RequestException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatHttpExceptionIsThrownForGuzzleBadResponseException()
    {
        $this->promise->reject(new GuzzleExceptions\BadResponseException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatHttpExceptionIsThrownForGuzzleClientException()
    {
        $this->promise->reject(new GuzzleExceptions\ClientException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatHttpExceptionIsThrownForGuzzleServerException()
    {
        $this->promise->reject(new GuzzleExceptions\ServerException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatTransferExceptionIsThrownForGuzzleTransferException()
    {
        $this->promise->reject(new GuzzleExceptions\TransferException('foo'));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(\Http\Client\Exception\TransferException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatRequestExceptionForGuzzleRequestException()
    {
        $this->promise->reject(new GuzzleExceptions\RequestException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatRequestExceptionForGuzzleBadResponseException()
    {
        $this->promise->reject(new GuzzleExceptions\BadResponseException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatRequestExceptionForGuzzleClientException()
    {
        $this->promise->reject(new GuzzleExceptions\ClientException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function testThatRequestExceptionForGuzzleServerException()
    {
        $this->promise->reject(new GuzzleExceptions\ServerException('foo', $this->request, $this->response));
        $promise = new Promise($this->promise, $this->request);
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }
}
