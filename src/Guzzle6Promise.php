<?php

namespace Http\Adapter;

use GuzzleHttp\Exception as GuzzleExceptions;
use GuzzleHttp\Promise\PromiseInterface;
use Http\Client\Exception as HttplugException;
use Http\Client\Promise;
use Psr\Http\Message\RequestInterface;
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
     * @var HttplugException
     */
    private $exception;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(PromiseInterface $promise, RequestInterface $request)
    {
        $this->request = $request;
        $this->state   = self::PENDING;
        $this->promise = $promise->then(function ($response) {
            $this->response = $response;
            $this->state = self::FULFILLED;

            return $response;
        }, function ($reason) use ($request) {
            if (!($reason instanceof GuzzleExceptions\GuzzleException)) {
                throw new \RuntimeException("Invalid reason");
            }

            $this->state     = self::REJECTED;
            $this->exception = $this->handleException($reason, $request);

            throw $this->exception;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        return new static($this->promise->then($onFulfilled, $onRejected), $this->request);
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

    /**
     * Converts a Guzzle exception into an Httplug exception.
     *
     * @param GuzzleExceptions\GuzzleException $exception
     * @param RequestInterface                 $request
     *
     * @return HttplugException
     */
    private function handleException(GuzzleExceptions\GuzzleException $exception, RequestInterface $request)
    {
        if ($exception instanceof GuzzleExceptions\SeekException) {
            return new HttplugException\RequestException($exception->getMessage(), $request, $exception);
        }

        if ($exception instanceof GuzzleExceptions\ConnectException) {
            return new HttplugException\NetworkException($exception->getMessage(), $exception->getRequest(), $exception);
        }

        if ($exception instanceof GuzzleExceptions\RequestException) {
            // Make sure we have a response for the HttpException
            if ($exception->hasResponse()) {
                return new HttplugException\HttpException(
                    $exception->getMessage(),
                    $exception->getRequest(),
                    $exception->getResponse(),
                    $exception
                );
            }

            return new HttplugException\RequestException($exception->getMessage(), $exception->getRequest(), $exception);
        }

        return new HttplugException\TransferException($exception->getMessage(), 0, $exception);
    }
}
 