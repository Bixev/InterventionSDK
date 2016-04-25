<?php

namespace Bixev\InterventionSdk\Model;

abstract class AbstractCollection extends AbstractModel implements \ArrayAccess, \Countable, \Iterator
{

    /**
     * @var array
     */
    protected $_data = [];

    /**
     * @var int Iterator implementation
     */
    protected $_iteratorPosition = 0;

    //#####     ArrayAccess     #####//

    public function offsetExists($offset)
    {
        return isset($this->_data[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!isset($this->_data[$offset])) {
            return null;
        }

        return $this->_data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->_data[] = $value;
        } else {
            $this->_data[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        if (isset($this->_data[$offset])) {
            if ($this->_iteratorPosition > array_search($offset, $this->_data)) {
                $this->_iteratorPosition--;
            }
            unset($this->_data[$offset]);
        }
    }

    //#####     Countable     #####//

    public function count()
    {
        return count($this->_data);
    }

    //#####     Iterator     #####//

    public function rewind()
    {
        $this->_iteratorPosition = 0;
    }

    public function current()
    {
        $keys = array_keys($this->_data);

        return $this->_data[$keys[$this->_iteratorPosition]];
    }

    public function key()
    {
        $keys = array_keys($this->_data);

        return $keys[$this->_iteratorPosition];
    }

    public function next()
    {
        ++$this->_iteratorPosition;
    }

    public function valid()
    {
        $keys = array_keys($this->_data);

        return array_key_exists($this->_iteratorPosition, $keys) && array_key_exists($keys[$this->_iteratorPosition], $this->_data);
    }

    //#####          #####//

    public function hydrate(array $data = [])
    {
        foreach ($data as $key => $value) {
            $this[$key] = $value;
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $return = [];
        foreach ($this as $key => $value) {
            $return[$key] = $value;
        }

        return $return;
    }


}