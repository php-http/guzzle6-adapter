<?php

declare(strict_types=1);

namespace Http\Adapter\Guzzle6\Tests;

use GuzzleHttp\Exception as GuzzleExceptions;
use Http\Adapter\Guzzle6\Exception\UnexpectedValueException;
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
     * @dataProvider exceptionThatIsThrownForGuzzleExceptionProvider
     */
    public function testExceptionThatIsThrownForGuzzleException(
        RequestInterface $request,
        $reason,
        string $adapterExceptionClass
    ) {
        $guzzlePromise = new \GuzzleHttp\Promise\Promise();
        $guzzlePromise->reject($reason);
        $promise = new Promise($guzzlePromise, $request);
        $this->expectException($adapterExceptionClass);
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
            // Non PSR-18 Exceptions thrown
            [$request, new \Exception('foo'), TransferException::class],
            [$request, new \Error('foo'), TransferException::class],
            [$request, 'whatever', UnexpectedValueException::class],
        ];
    }
}
