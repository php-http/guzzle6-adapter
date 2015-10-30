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
use GuzzleHttp\Exception\RequestException;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\Exception;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

/**
 * @author David de Boer <david@ddeboer.nl>
 */
class Guzzle6HttpAdapter implements HttpClient
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
        } catch (RequestException $e) {
            throw $this->createException($e);
        }
    }

    /**
     * Converts a Guzzle exception into an Httplug exception.
     *
     * @param RequestException $exception
     *
     * @return Exception
     */
    private function createException(RequestException $exception)
    {
        if ($exception->hasResponse()) {
            return new HttpException($exception->getMessage(), $exception->getRequest(), $exception->getResponse(), $exception);
        }

        return new NetworkException($exception->getMessage(), $exception->getRequest(), $exception);
    }
}
