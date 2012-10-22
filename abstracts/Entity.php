<?php

namespace Abstracts;

class Entity
{

    private $caller;

    public function __construct($data = null) {

        if (is_array($data))
            $this->exchangeArray($data);
    }

    /**
     * Getter and setters generation
     * @param string $name Name of method
     * @param string $arguments Arguments of called method
     * @return \Abstracts\Entity
     * @throws \RuntimeException
     */
    public function __call($name, $arguments)
    {
        switch (substr($name, 0, 3)) {
            case 'get':
                return $this->getter($name);
            break;

            case 'set':
                if (!isset($arguments[0]))
                     throw new \RuntimeException('Missed property value');

                if (!$this->setter($name, $arguments[0]) === null)
                    throw new \RuntimeException('Property not exist');

                return $this;
            break;
        }

    }

    /**
     * Generic getter
     * @param string $method Method name
     * @return mixed Property value
     */
    private function getter($method)
    {
        $name = $this->getPropertyName($method);
        return $this->propertyExists( $name)? $this->$name: null;
    }

    /**
     * Generic setter
     * @param string $method Method name
     * @param mixed $value Property Value
     * @return \Abstract\Model|null
     */
    private function setter($method, $value)
    {
        $name = $this->getPropertyName($method);
        if ($this->propertyExists( $name))
            return $this->$name = $value;
        else
            return null;
    }

    /**
     * Parse property name from setter/getter
     * @param type $method Method name
     * @return string Property name
     */
    private function getPropertyName($method)
    {
        $name = substr($method, 3);
        $name[0] = strtolower($name[0]);
        return $name;
    }

    /**
     * Seriallizing entity in asociative array
     * @return array Array with entity property
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


    /**
     * Init entity fields from array
     * @param array $data
     * @return $this
     */
    public function exchangeArray($data = array())
    {
        foreach ($data as $key => $value) {
            if ($this->propertyExists( $key))
                $this->$key = $value;
        }
        return $this;
    }

    /**
     * Alias for $this->exchangeArray
     */
    public function populate($data = array())
    {
        return $this->exchangeArray($data);
    }

    private function propertyExists($property)
    {
        if (!$this->caller)
            $this->caller = get_called_class();

        return property_exists($this->caller, $property);
    }
}