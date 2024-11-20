<?php

namespace Rougin\Dexterity\Route;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\HttpResponse;

trait WithShowMethod
{
    public function show($id, ServerRequestInterface $request)
    {
        /** @var array<string, mixed> */
        $params = $request->getQueryParams();

        if (! $this->isShowValid($params))
        {
            return $this->invalidShow();
        }

        return $this->setShowData($id, $params);
    }

    protected function invalidShow()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    protected function isShowValid($params)
    {
        return true;
    }

    protected function setShowData($id, $params)
    {
        return new HttpResponse;
    }
}
