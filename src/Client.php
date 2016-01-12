<?php

namespace Http\Adapter\Guzzle6;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Psr\Http\Message\RequestInterface;

/**
 * HTTP Adapter for Guzzle 6.
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class Client implements HttpClient, HttpAsyncClient
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
        if (!$client) {
            $handlerStack = new HandlerStack(\GuzzleHttp\choose_handler());
            $handlerStack->push(Middleware::prepareBody(), 'prepare_body');
            $client = new GuzzleClient(['handler' => $handlerStack]);
        }

        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest(RequestInterface $request)
    {
        $promise = $this->sendAsyncRequest($request);

        return $promise->wait();
    }

    /**
     * {@inheritdoc}
     */
    public function sendAsyncRequest(RequestInterface $request)
    {
        $promise = $this->client->sendAsync($request);

        return new Promise($promise, $request);
    }
}
