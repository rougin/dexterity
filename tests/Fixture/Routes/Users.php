<?php

namespace Rougin\Dexterity\Fixture\Routes;

use Rougin\Dexterity\Fixture\Depots\UserDepot;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithDeleteMethod;
use Rougin\Dexterity\Route\WithIndexMethod;
use Rougin\Dexterity\Route\WithShowMethod;
use Rougin\Dexterity\Route\WithStoreMethod;
use Rougin\Dexterity\Route\WithUpdateMethod;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Users
{
    use WithDeleteMethod;
    use WithIndexMethod;
    use WithShowMethod;
    use WithStoreMethod;
    use WithUpdateMethod;

    /**
     * @var \Rougin\Dexterity\Fixture\Depots\UserDepot
     */
    protected $user;

    /**
     * @param \Rougin\Dexterity\Fixture\Depots\UserDepot $user
     */
    public function __construct(UserDepot $user)
    {
       $this->user = $user;
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
        $this->user->delete($id);

        return new JsonResponse('Deleted!', 204);
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        $result = $this->user->get(1, 10);

        $data = $result->toArray();

        return new JsonResponse($data);
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
        $item = $this->user->find($id)->asRow();

        return new JsonResponse($item);
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
        /** @var \Rougin\Dexterity\Fixture\Models\User */
        $item = $this->user->create($parsed);

        return new JsonResponse($item->id, 201);
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
        $this->user->update($id, $parsed);

        return new JsonResponse('Updated!', 204);
    }
}
