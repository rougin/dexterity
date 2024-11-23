<?php

namespace Rougin\Dexterity\Legacy\Repository;

use Doctrine\ORM\EntityManager;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class DoctrineRepository implements ReadableInterface
{
    /**
     * @var string
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Initializes the repository instance.
     *
     * @param \Doctrine\ORM\EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Deletes the specified resource from storage.
     *
     * @param array|integer $id
     *
     * @return boolean
     */
    public function delete($id)
    {
        $item = $this->find((int) $id);

        $this->manager->remove($item);

        return $this->manager->flush();
    }

    /**
     * Finds the specified resource from storage.
     *
     * @param array|integer $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->manager->find($this->entity, $id);
    }

    /**
     * Sets the resource for the repository.
     *
     * @param string $resource
     *
     * @return self
     */
    public function resource($resource)
    {
        $this->entity = $resource;

        return $this;
    }

    /**
     * Paginates the specified page number and items per page.
     *
     * @param integer $page
     * @param integer $limit
     * @param array   $criteria
     * @param array   $order
     *
     * @return array
     */
    public function paginate($page, $limit, $criteria = array(), $order = array())
    {
        $repository = $this->manager->getRepository($this->entity);

        return $repository->findBy($criteria, $order, $limit, $page);
    }

    /**
     * Calls methods from the EntityRepository instance.
     *
     * @param string $method
     * @param mixed  $parameters
     *
     * @return self
     */
    public function __call($method, $parameters)
    {
        $repository = $this->manager->getRepository($this->entity);

        $class = array($repository, (string) $method);

        return call_user_func_array($class, $parameters);
    }
}
