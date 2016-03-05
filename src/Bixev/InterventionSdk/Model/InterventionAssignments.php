<?php

namespace Bixev\InterventionSdk\Model;

class InterventionAssignments extends AbstractCollection
{

    /**
     * @return User
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }

    /**
     * @return User
     */
    public function current()
    {
        return parent::current();
    }

    public function offsetSet($offset, $value)
    {
        if (!($value instanceof User)) {
            throw new \Bixev\InterventionSdk\Exception('trying to set non valid element');
        }
        parent::offsetSet($offset, $value);
    }

    public function hydrate(array $data = array())
    {
        foreach ($data as $value) {
            $assignment = new User();
            $assignment->hydrate($value);
            $this[] = $assignment;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $return = array();
        foreach ($this as $data) {
            $return[] = $data->toArray();
        }
        return $return;
    }

}