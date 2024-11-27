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
        /** @var array<string, mixed> */
        $item = $this->user->find($id);

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
}
