<?php

namespace Dangje\WebFramework\Factory;

use Dangje\WebFramework\Message\Request;
use Dangje\WebFramework\Message\Stream;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

class RequestFactory implements RequestFactoryInterface
{

    public function createRequest(string $method = '', $uri = ''): RequestInterface
    {
        $uriFactory = new UriFactory();
        $requestTarget =
            $_SERVER['REQUEST_TARGET'] ?? '/';
        $method =
            $method != ''  ? $method : $_SERVER['REQUEST_METHOD'];;
        $uri = $uriFactory->createUri(
            $uri != '' ? $uri : $_SERVER['REQUEST_URI']);

        return new Request(
            $requestTarget,
            $method,
            $uri,
            getallheaders(),
            $this->getBody(),
        );
    }

    private function getBody(): StreamInterface
    {
        return new Stream('php://input');
    }
}