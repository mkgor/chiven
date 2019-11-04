<?php

namespace Chiven\Http\Repository;

use Chiven\Http\Entity\Insertable;

/**
 * Interface RepositoryInterface
 *
 * @package Chiven\Http\Repository
 */
interface RepositoryInterface
{
    /**
     * @param string $criteria Property to search
     * @param string $value Value of property
     *
     * @return Insertable[]
     */
    public function findBy($criteria, $value);

    /**
     * @return Insertable
     */
    public function findLast();

    /**
     * @return Insertable
     */
    public function findFirst();

    /**
     * @return Insertable[]
     */
    public function findAll();

    /**
     * @param Insertable $object
     *
     * @return void
     */
    public function insert(Insertable $object): void;

    /**
     * @param $criteria
     * @param $value
     *
     * @return mixed
     */
    public function remove($criteria, $value);

    /**
     * @param Insertable[] $objects
     *
     * @return void
     */
    public function set(array $objects): void;
}