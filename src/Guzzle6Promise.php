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
    private $error;

    public function __construct(PromiseInterface $promise)
    {
        $this->promise = $promise;
        $this->state   = self::PENDING;
    }

    /**
     * {@inheritdoc}
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        $onFulfilledInternal = function ($response) use($onFulfilled) {
            $this->response = $response;
            $this->state = self::FULFILLED;

            return $onFulfilled($this->response);
        };

        $onRejectedInternal = function ($reason) use($onRejected) {
            if (!($reason instanceof RequestException)) {
                 throw new \RuntimeException("Invalid reason");
            }

            $this->state = self::REJECTED;
            $this->error = new Exception\NetworkException($reason->getMessage(), $reason->getRequest(), $reason);

            if ($reason->hasResponse()) {
                $this->error = new Exception\HttpException($reason->getMessage(), $reason->getRequest(), $reason->getResponse(), $reason);
            }

            return $onRejected($this->error);
        };

        $this->promise = $this->promise->then($onFulfilledInternal, $onRejectedInternal);

        return new static($this->promise);
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
    public function getError()
    {
        if (self::REJECTED !== $this->state) {
            throw new \LogicException("Error not available for the current state");
        }

        return $this->error;
    }

    /**
     * {@inheritdoc}
     */
    public function wait()
    {
        $this->promise->wait(false);
    }
}
 