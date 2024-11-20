<?php

namespace Rougin\Dexterity\Route;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\HttpResponse;

trait WithDeleteMethod
{
    public function delete($id, ServerRequestInterface $request)
    {
        if (! $this->isDeleteValid())
        {
            return $this->invalidDelete();
        }

        return $this->setDeleteData($id);
    }

    protected function invalidDelete()
    {
        return new ErrorResponse(HttpResponse::NOT_FOUND);
    }

    protected function isDeleteValid()
    {
        return true;
    }

    protected function setDeleteData($id)
    {
        return new HttpResponse;
    }
}
