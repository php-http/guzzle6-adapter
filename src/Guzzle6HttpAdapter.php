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
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use Http\Adapter\Common\Exception\HttpAdapterException;
use Http\Adapter\Common\Exception\MultiHttpAdapterException;
use Psr\Http\Message\RequestInterface;

/**
 * Guzzle 6 HTTP adapter
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class Guzzle6HttpAdapter implements PsrHttpAdapter
{
    /**
     * @param Client $client
     */
    public function __construct(Client $client = null)
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
        } catch (RequestException $exception) {
            throw new $this->createException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequests(array $requests)
    {
        $results = Pool::batch(
            $this->client,
            $requests
        );

        $exceptions = [];
        foreach ($results as $result) {
            if ($result instanceof TransferException) {
                $exceptions[] = $this->createException($result);
            }
        }

        if (count($exceptions) > 0) {
            throw new MultiHttpAdapterException($exceptions);
        }

        return $results;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'guzzle6';
    }

    /**
     * Convert Guzzle exception into HttpAdapter exception
     *
     * @param RequestException $exception
     *
     * @return HttpAdapterException
     */
    private function createException(RequestException $exception)
    {
        $adapterException = new HttpAdapterException(
            $exception->getMessage(),
            0,
            $exception
        );
        $adapterException->setResponse($exception->getResponse());
        $adapterException->setRequest($exception->getRequest());

        return $adapterException;
    }
}
