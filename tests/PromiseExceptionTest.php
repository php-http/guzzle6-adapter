<?php

declare(strict_types=1);

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Exception as GuzzleExceptions;
use GuzzleHttp\Promise\PromiseInterface;
use Http\Adapter\Guzzle6\Promise;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\Exception\RequestException;
use Http\Client\Exception\TransferException;
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
     * @param RequestInterface $request
     * @param \Exception $guzzleException
     * @param string $adapterExceptionClass
     * @dataProvider exceptionThatIsThrownForGuzzleExceptionProvider
     */
    public function testExceptionThatIsThrownForGuzzleException(
        RequestInterface $request,
        \Exception $guzzleException,
        string $adapterExceptionClass
    ) {
        $guzzlePromise = new \GuzzleHttp\Promise\Promise();
        $guzzlePromise->reject($guzzleException);
        $promise = new Promise($guzzlePromise, $request);
        $this->expectException($adapterExceptionClass);
        $this->expectExceptionMessage('foo');
        $promise->wait();
    }

    public function exceptionThatIsThrownForGuzzleExceptionProvider(): array
    {
        $request = $this->getMockBuilder(RequestInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();

        return [
            [$request, new GuzzleExceptions\ConnectException('foo', $request), NetworkException::class],
            [$request, new GuzzleExceptions\TooManyRedirectsException('foo', $request), RequestException::class],
            [$request, new GuzzleExceptions\RequestException('foo', $request, $response), HttpException::class],
            [$request, new GuzzleExceptions\BadResponseException('foo', $request, $response), HttpException::class],
            [$request, new GuzzleExceptions\ClientException('foo', $request, $response), HttpException::class],
            [$request, new GuzzleExceptions\ServerException('foo', $request, $response), HttpException::class],
            [$request, new GuzzleExceptions\TransferException('foo'), TransferException::class],
            // check cases without response
            [$request, new GuzzleExceptions\RequestException('foo', $request), RequestException::class],
            [$request, new GuzzleExceptions\BadResponseException('foo', $request), RequestException::class],
            [$request, new GuzzleExceptions\ClientException('foo', $request), RequestException::class],
            [$request, new GuzzleExceptions\ServerException('foo', $request), RequestException::class],
        ];
    }
}
