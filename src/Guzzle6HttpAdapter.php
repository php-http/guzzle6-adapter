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
use Http\Adapter\Common\Exception\HttpAdapterException;
use Http\Adapter\Common\Exception\MultiHttpAdapterException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Guzzle 6 HTTP adapter
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class Guzzle6HttpAdapter implements HttpAdapter
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface|null $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request, array $options = [])
    {
        $options = $this->buildOptions($options);

        try {
            return $this->client->send($request, $options);
        } catch (RequestException $e) {
            throw $this->createException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequests(array $requests, array $options = [])
    {
        $options = $this->buildOptions($options);

        $results = Pool::batch($this->client, $requests, $options);

        $exceptions = [];
        $responses = [];

        foreach ($results as $result) {
            if ($result instanceof ResponseInterface) {
                $responses[] = $result;
            } elseif ($result instanceof RequestException) {
                $exceptions[] = $this->createException($result);
            }
        }

        if (count($exceptions) > 0) {
            throw new MultiHttpAdapterException($exceptions, $responses);
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
     * Converts a Guzzle exception into an HttpAdapter exception
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
