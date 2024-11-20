<?php

namespace Rougin\Dexterity\Route;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\HttpResponse;

trait WithUpdateMethod
{
    public function update($id, ServerRequestInterface $request)
    {
        /** @var array<string, mixed> */
        $parsed = $request->getParsedBody();

        if (! $this->isUpdateValid($parsed))
        {
            return $this->invalidUpdate();
        }

        return $this->setUpdateData($id, $parsed);
    }

    protected function invalidUpdate()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    protected function isUpdateValid($parsed)
    {
        return true;
    }

    protected function setUpdateData($id, $parsed)
    {
        return new HttpResponse;
    }
}
