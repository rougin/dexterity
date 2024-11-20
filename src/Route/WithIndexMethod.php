<?php

namespace Rougin\Dexterity\Route;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\HttpResponse;

trait WithIndexMethod
{
    public function index(ServerRequestInterface $request)
    {
        /** @var array<string, mixed> */
        $params = $request->getQueryParams();

        if (! $this->isIndexValid($params))
        {
            return $this->invalidIndex();
        }

        return $this->setIndexData($params);
    }

    protected function invalidIndex()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    protected function isIndexValid($params)
    {
        return true;
    }

    protected function setIndexData($params)
    {
        return new HttpResponse;
    }
}
