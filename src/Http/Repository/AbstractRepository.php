<?php

namespace Chiven\Http\Repository;

use Chiven\Http\Entity\Insertable;

/**
 * Class AbstractRepository
 *
 * @package Chiven\Http\Repository
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var Insertable[]
     */
    private $container;

    /**
     * @param string $criteria Property to search
     * @param string $value Value of property
     *
     * @return Insertable|null
     */
    public function findBy($criteria, $value)
    {
        $result = null;

        foreach($this->container as $containerItem) {
            foreach($containerItem->getValuesToIterate() as $key => $itemValue) {
                if($key == $criteria && $value == $itemValue) {
                    $result = $containerItem;
                }
            }
        }

        return $result;
    }

    /**
     * @return Insertable|mixed
     */
    public function findLast()
    {
        return end($this->container);
    }

    /**
     * @return Insertable|mixed
     */
    public function findFirst()
    {
        return current($this->container);
    }

    /**
     * @return Insertable[]
     */
    public function findAll()
    {
        return $this->container;
    }

    /**
     * @param Insertable $object
     *
     * @return void
     */
    public function insert(Insertable $object): void
    {
        $this->container[] = $object;
    }

    /**
     * @param $criteria
     * @param $value
     *
     * @return mixed
     */
    public function remove($criteria, $value, $removeAll = false)
    {
        $result = false;

        foreach($this->container as $i => $containerItem) {
            foreach($containerItem->getValuesToIterate() as $key => $itemValue) {
                if($key == $criteria && $value == $itemValue) {
                    unset($this->container[$i]);
                    $result = true;

                    if(!$removeAll) {
                        break;
                    }
                }
            }

        }

        return $result;
    }

    /**
     * @param Insertable[] $objects
     * @codeCoverageIgnore
     * @return void
     */
    public function set(array $objects): void
    {
        $this->container = $objects;
    }
}