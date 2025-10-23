<?php

namespace Rougin\Dexterity;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\HttpResponse;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Route
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
     * Returns an array of items.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
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

    /**
     * Returns the specified item.
     *
     * @param integer                                  $id
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($id, ServerRequestInterface $request)
    {
        /** @var array<string, mixed> */
        $params = $request->getQueryParams();

        if (! $this->isShowValid($id, $params))
        {
            return $this->invalidShow();
        }

        return $this->setShowData($id, $params);
    }

    /**
     * Creates a new item.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
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

    /**
     * Updates the specified item.
     *
     * @param integer                                  $id
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update($id, ServerRequestInterface $request)
    {
        /** @var array<string, mixed> */
        $parsed = $request->getParsedBody();

        if (! $this->isUpdateValid($id, $parsed))
        {
            return $this->invalidUpdate();
        }

        return $this->setUpdateData($id, $parsed);
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
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidIndex()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidShow()
    {
        return new ErrorResponse(HttpResponse::NOT_FOUND);
    }

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidUpdate()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
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
     * Checks if the items are allowed to be returned.
     *
     * @param array<string, mixed> $params
     *
     * @return boolean
     */
    protected function isIndexValid($params)
    {
        return true;
    }

    /**
     * Checks if the specified item is allowed to be returned.
     *
     * @param integer              $id
     * @param array<string, mixed> $params
     *
     * @return boolean
     */
    protected function isShowValid($id, $params)
    {
        return true;
    }

    /**
     * Checks if it is allowed to create a new item.
     *
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isStoreValid($parsed)
    {
        return true;
    }

    /**
     * Checks if the specified item can be updated.
     *
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isUpdateValid($id, $parsed)
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

    /**
     * Executes the logic for returning an array of items.
     *
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
    }

    /**
     * Executes the logic for returning the specified item.
     *
     * @param integer              $id
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setShowData($id, $params)
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
    }

    /**
     * Executes the logic for creating a new item.
     *
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
    }

    /**
     * Executes the logic for updating the specified item.
     *
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setUpdateData($id, $parsed)
    {
        $text = 'The "[METHOD]" method must be overwriten in the concrete class.';

        throw new \LogicException(str_replace('[METHOD]', __FUNCTION__, $text));
    }
}
