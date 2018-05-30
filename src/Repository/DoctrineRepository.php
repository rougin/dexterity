<?php

namespace Rougin\Dexterity\Repository;

use Doctrine\ORM\EntityManager;

/**
 * Doctrine Repository
 *
 * @package Dexterity
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DoctrineRepository implements RepositoryInterface
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
     * Stores a newly created resource in storage.
     *
     * @param  array $data
     * @return mixed
     */
    public function create($data)
    {
        $entity = new $this->entity;

        $entity->create($data);

        $this->manager->persist($entity);

        $this->manager->flush();

        // TODO: Add "create" functionality from Doctrine.
        // Please avoid using custom queries as possible.
    }

    /**
     * Deletes the specified resource from storage.
     *
     * @param  array|integer $id
     * @return boolean
     */
    public function delete($id)
    {
        // TODO: Add "delete" functionality from Doctrine.
        // Please avoid using custom queries as possible.
    }

    /**
     * Finds the specified resource from storage.
     *
     * @param  array|integer $id
     * @return mixed
     */
    public function find($id)
    {
        // TODO: Add "find" functionality from Doctrine.
        // Please avoid using custom queries as possible.
    }

    /**
     * Sets the resource for the repository.
     *
     * @param  string $resource
     * @return self
     */
    public function resource($resource)
    {
        $this->entity = $resource;

        return $this;

        // TODO: Add "resource" functionality from Doctrine.
        // Please avoid using custom queries as possible.
    }

    /**
     * Paginates the specified page number and items per page.
     *
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function paginate($page, $limit)
    {
        // TODO: Add "paginate" functionality from Doctrine.
        // Please avoid using custom queries as possible.
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  array|integer $id
     * @param  array         $data
     * @return boolean
     */
    public function update($id, $data)
    {
        // TODO: Add "update" functionality from Doctrine.
        // Please avoid using custom queries as possible.
    }
}
