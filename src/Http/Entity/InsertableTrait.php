<?php

namespace Chiven\Http\Entity;

trait InsertableTrait
{
    /**
     * @return array
     */
    public function getValuesToIterate()
    {
        $result = [];

        foreach(get_class_vars(get_class($this)) as $key => $value) {
            $result[$key] = $this->{$key};
        }

        return $result;
    }
}