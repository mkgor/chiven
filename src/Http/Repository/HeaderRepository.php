<?php

namespace Chiven\Http\Repository;

use Chiven\Http\Entity\Header;
use Chiven\Http\Entity\Insertable;

/**
 * Class HeaderRepository
 *
 * @package Chiven\Http\Repository
 */
class HeaderRepository extends AbstractRepository
{
    /**
     * @param Insertable $object
     *
     * @return void
     */
    public function insert(Insertable $object): void
    {
        if(parent::findBy('name', $object->getName()) instanceof Insertable) {
            parent::remove('name', $object->getName());
        }

        parent::insert($object);
    }

    public function setContainer(array $container): void
    {
        $namesArray = [];

        /** @var Header $item */
        foreach($container as $i => $item) {
            if(in_array($item->getName(), $namesArray)) {
                foreach($container as $k => $subItem) {
                    if($subItem->getName() == $item->getName()) {
                        unset($container[$k]);
                        break;
                    }
                }
            } else {
                $namesArray[$i] = $item->getName();
            }
        }

        parent::setContainer($container);
    }
}