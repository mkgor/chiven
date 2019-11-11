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
    protected $container;

    /**
     * @return Insertable[]
     * @codeCoverageIgnore
     */
    public function getContainer(): array
    {
        return $this->container;
    }

    /**
     * @param Insertable[] $container
     * @codeCoverageIgnore
     */
    public function setContainer(array $container): void
    {
        $this->container = $container;
    }

    /**
     * @param string $criteria Property to search
     * @param string $value Value of property
     *
     * @return Insertable|null
     */
    public function findBy($criteria, $value)
    {
        $result = null;

        if(!empty($this->container)) {
            foreach ($this->container as $containerItem) {
                foreach ($containerItem->getValuesToIterate() as $key => $itemValue) {
                    if ($key == $criteria && $value == $itemValue) {
                        $result = $containerItem;
                    }
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
     * @param bool $removeAll
     * @return mixed
     */
    public function remove($criteria, $value, $removeAll = false)
    {
        $result = false;

        if(!empty($this->container)) {
            foreach ($this->container as $i => $containerItem) {
                foreach ($containerItem->getValuesToIterate() as $key => $itemValue) {
                    if ($key == $criteria && $value == $itemValue) {
                        unset($this->container[$i]);
                        $result = true;

                        if (!$removeAll) {
                            break;
                        }
                    }
                }
            }
        }

        return $result;
    }

}