<?php

namespace Http\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Client\Tools\HttpClientEmulator;
use Psr\Http\Message\RequestInterface;

/**
 * HTTP Adapter for Guzzle 6.
 *
 * @author David de Boer <david@ddeboer.nl>
 */
class Guzzle6HttpAdapter implements HttpClient, HttpAsyncClient
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
            $client = new Client(['handler' => $handlerStack]);
        }
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function sendAsyncRequest(RequestInterface $request)
    {
        $promise = $this->client->sendAsync($request);

        return new Guzzle6Promise($promise, $request);
    }
}
