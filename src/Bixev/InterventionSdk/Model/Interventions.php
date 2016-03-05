<?php

namespace Bixev\InterventionSdk\Model;

class Interventions extends AbstractCollection
{

    /**
     * @return Intervention
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }

    /**
     * @return Intervention
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @param mixed $offset
     * @param Intervention $value
     */
    public function offsetSet($offset, $value)
    {
        if (!($value instanceof Intervention)) {
            throw new \Bixev\InterventionSdk\Exception('trying to set non valid element');
        }
        parent::offsetSet($offset, $value);
    }

    public function hydrate(array $data = array())
    {
        foreach ($data as $value) {
            $intervention = new Intervention();
            $intervention->hydrate($value);
            $this[] = $intervention;
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