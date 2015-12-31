<?php

namespace Http\Adapter\Guzzle6;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Client\Common\HttpClientEmulator;
use Psr\Http\Message\RequestInterface;

/**
 * HTTP Adapter for Guzzle 6.
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class Client implements HttpClient, HttpAsyncClient
{
    use HttpClientEmulator;

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
    public function sendAsyncRequest(RequestInterface $request)
    {
        $promise = $this->client->sendAsync($request);

        return new Promise($promise, $request);
    }
}
