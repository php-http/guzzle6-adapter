<?php

/**
 * This file is part of the Http Adapter package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */
namespace Http\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception as GuzzleExceptions;
use Http\Client\Exception;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\Exception\RequestException;
use Http\Client\Exception\TransferException;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

/**
 * @author David de Boer <david@ddeboer.nl>
 */
class Guzzle6HttpAdapter implements HttpClient, HttpAsyncClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface|null $client Guzzle client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        try {
            return $this->client->send($request);
        } catch (GuzzleExceptions\SeekException $e) {
            throw new RequestException($e->getMessage(), $request, $e);
        } catch (GuzzleExceptions\GuzzleException $e) {
            throw $this->handleException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sendAsyncRequest(RequestInterface $request)
    {
        return new Guzzle6Promise($this->client->sendAsync($request));
    }

    /**
     * Converts a Guzzle exception into an Httplug exception.
     *
     * @param GuzzleExceptions\GuzzleException $exception
     *
     * @return Exception
     */
    private function handleException(GuzzleExceptions\GuzzleException $exception)
    {
        if ($exception instanceof GuzzleExceptions\ConnectException) {
            return new NetworkException($exception->getMessage(), $exception->getRequest(), $exception);
        }

        if ($exception instanceof GuzzleExceptions\RequestException) {
            // Make sure we have a response for the HttpException
            if ($exception->hasResponse()) {
                return new HttpException(
                    $exception->getMessage(),
                    $exception->getRequest(),
                    $exception->getResponse(),
                    $exception
                );
            }

            return new RequestException($exception->getMessage(), $exception->getRequest(), $exception);
        }

        return new TransferException($exception->getMessage(), 0, $exception);
    }
}
