<?php

namespace Rougin\Dexterity\Route;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\HttpResponse;

trait WithStoreMethod
{
    public function store(ServerRequestInterface $request)
    {
        /** @var array<string, mixed> */
        $parsed = $request->getParsedBody();

        if (! $this->isStoreValid($parsed))
        {
            return $this->invalidStore();
        }

        return $this->setStoreData($parsed);
    }

    protected function invalidStore()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    protected function isStoreValid($parsed)
    {
        return true;
    }

    protected function setStoreData($parsed)
    {
        return new HttpResponse;
    }
}
