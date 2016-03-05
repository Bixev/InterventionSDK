<?php

namespace Bixev\InterventionSdk\Model\Routes;

class Routes extends \Bixev\InterventionSdk\Model\AbstractCollection
{

    /**
     * @return Route
     */
    public function offsetGet($offset)
    {
        return parent::offsetGet($offset);
    }

    /**
     * @return Route
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @param mixed $offset
     * @param Route $value
     */
    public function offsetSet($offset, $value)
    {
        if (!($value instanceof Route) || !$value->isValid()) {
            throw new \Bixev\InterventionSdk\Exception('trying to set non valid route');
        }

        if ($this->findByIdentifier($value->identifier) !== null) {
            foreach ($this as $k => $route) {
                if ($route->identifier == $value->identifier) {
                    $this[$k] = $value;
                }
            }
        } else {
            parent::offsetSet($offset, $value);
        }
    }

    public function hydrate(array $data = [])
    {
        foreach ($data as $value) {
            $intervention = new Route();
            $intervention->hydrate($value);
            $this[] = $intervention;
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

    /**
     * @param string $routeIdentifier
     * @return Route|null
     */
    public function findByIdentifier($routeIdentifier)
    {
        foreach ($this as $route) {
            if ($route->identifier == $routeIdentifier) {
                return $route;
            }
        }

        return null;
    }

    /**
     * @param string $routeIdentifier
     * @return Route|null
     */
    public function deleteByIdentifier($routeIdentifier)
    {
        foreach ($this as $k => $route) {
            if ($route->identifier == $routeIdentifier) {
                unset($this[$k]);

                return true;
            }
        }

        return false;
    }

}