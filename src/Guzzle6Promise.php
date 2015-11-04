<?php

namespace Http\Adapter;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Http\Client\Exception;
use Http\Client\Promise;
use Psr\Http\Message\ResponseInterface;

class Guzzle6Promise implements Promise
{
    /**
     * @var \GuzzleHttp\Promise\PromiseInterface
     */
    private $promise;

    /**
     * @var string State of the promise
     */
    private $state;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var Exception
     */
    private $exception;

    public function __construct(PromiseInterface $promise)
    {
        $this->promise = $promise->then(function ($response) {
            $this->response = $response;
            $this->state = self::FULFILLED;

            return $response;
        }, function ($reason) {
            if (!($reason instanceof RequestException)) {
                throw new \RuntimeException("Invalid reason");
            }

            $this->state    = self::REJECTED;
            $this->exception = new Exception\NetworkException($reason->getMessage(), $reason->getRequest(), $reason);

            if ($reason->hasResponse()) {
                $this->exception = new Exception\HttpException($reason->getMessage(), $reason->getRequest(), $reason->getResponse(), $reason);
            }

            throw $this->exception;
        });

        $this->state   = self::PENDING;
    }

    /**
     * {@inheritdoc}
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        return new static($this->promise->then($onFulfilled, $onRejected));
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }


    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        if (self::FULFILLED !== $this->state) {
            throw new \LogicException("Response not available for the current state");
        }

        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function getException()
    {
        if (self::REJECTED !== $this->state) {
            throw new \LogicException("Error not available for the current state");
        }

        return $this->exception;
    }

    /**
     * {@inheritdoc}
     */
    public function wait()
    {
        $this->promise->wait(false);
    }
}
 