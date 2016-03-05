<?php

namespace Bixev\InterventionSdk\Model;

class InterventionTypes extends AbstractCollection
{

    /**
     * @return InterventionType
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }

    /**
     * @return InterventionType
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @param mixed $offset
     * @param InterventionType $value
     */
    public function offsetSet($offset, $value)
    {
        if (!($value instanceof InterventionType)) {
            throw new \Bixev\InterventionSdk\Exception('trying to set non valid element');
        }
        parent::offsetSet($offset, $value);
    }

    public function hydrate(array $data = [])
    {
        foreach ($data as $value) {
            $interventionType = new InterventionType();
            $interventionType->hydrate($value);
            $this[] = $interventionType;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $return = [];
        foreach ($this as $data) {
            $return[] = $data->toArray();
        }

        return $return;
    }

}