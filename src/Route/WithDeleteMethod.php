<?php

namespace Rougin\Dexterity\Route;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\HttpResponse;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
trait WithDeleteMethod
{
    /**
     * Deletes the specified item.
     *
     * @param integer                                  $id
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($id, ServerRequestInterface $request)
    {
        if (! $this->isDeleteValid($id))
        {
            return $this->invalidDelete();
        }

        return $this->setDeleteData($id);
    }

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidDelete()
    {
        return new ErrorResponse(HttpResponse::NOT_FOUND);
    }

    /**
     * Checks if the specified item can be deleted.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function isDeleteValid($id)
    {
        return true;
    }

    /**
     * Executes the logic for deleting the specified item.
     *
     * @param integer $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setDeleteData($id)
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
    }
}
