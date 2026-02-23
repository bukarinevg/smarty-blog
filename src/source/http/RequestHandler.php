<?php
declare(strict_types=1);

namespace app\source\http;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestHandler
 *
 * This class handles HTTP requests.
 * Based on the Symfony HttpFoundation component.
 * PSR-7 compatible.
 */
class RequestHandler
{
    private Request $request;

    public function __construct()
    {
        $this->setRequest(Request::createFromGlobals());
    }

    public function getUrlParam(string $name): string|int|float|bool|null
    {
        return $this->getRequest()->query->get($name);
    }

    public function getContent(): array|string|null
    {
        if ($this->isJson($this->request->getContent())) {
            return $this->request->toArray();
        } else {
            return null;
        }
    }

    function isJson(string $string): bool
    {
        return json_validate($string);
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): RequestHandler
    {
        $this->request = $request;

        return $this;
    }

    public function getRequestMethod(): string
    {
        return $this->request->getMethod();
    }
}

