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
use GuzzleHttp\Pool;
use Http\Client\Exception\BatchException;
use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\HttpClient;
use Http\Client\Utils\BatchResult;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
     * @var array Options to pass when sending one or multiple requests with guzzle
     */
    private $options;

    /**
     * @param ClientInterface|null $client  Guzzle client
     * @param array                $options Options to pass when sending one or multiple requests with guzzle
     */
    public function __construct(ClientInterface $client = null, array $options = [])
    {
        $this->client  = $client ?: new Client();
        $this->options = $this->buildOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        try {
            return $this->client->send($request, $this->options);
        } catch (RequestException $e) {
            throw $this->createException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequests(array $requests)
    {
        $poolResult  = Pool::batch($this->client, $requests, ['options' => $this->options]);
        $batchResult = new BatchResult();

        foreach ($poolResult as $index => $result) {
            if ($result instanceof ResponseInterface) {
                $batchResult = $batchResult->addResponse($requests[$index], $result);
            }

            if ($result instanceof RequestException) {
                $batchResult = $batchResult->addException($requests[$index], $this->createException($result));
            }
        }

        if ($batchResult->hasExceptions()) {
            throw new BatchException($batchResult);
        }

        return $batchResult;
    }

    /**
     * Converts a Guzzle exception into an Httplug exception
     *
     * @param RequestException $exception
     *
     * @return HttpException|NetworkException Return an HttpException if response is available, NetworkException otherwise
     */
    private function createException(RequestException $exception)
    {
        if ($exception->hasResponse()) {
            return new HttpException($exception->getMessage(), $exception->getRequest(), $exception->getResponse(), $exception);
        }

        return new NetworkException($exception->getMessage(), $exception->getRequest(), $exception);
    }

    /**
     * Builds options for Guzzle
     *
     * @param array $options
     *
     * @return array
     */
    private function buildOptions(array $options)
    {
        $guzzleOptions = [
            'http_errors'     => false,
            'allow_redirects' => false,
        ];

        if (isset($options['timeout'])) {
            $guzzleOptions['connect_timeout'] = $options['timeout'];
            $guzzleOptions['timeout'] = $options['timeout'];
        }

        return $guzzleOptions;
    }
}
