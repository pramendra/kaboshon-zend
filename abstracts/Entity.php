<?php

namespace Abstracts;

class Entity
{

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

                if ($this->setter($name, $arguments[0]) === null)
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
        return isset($this->$name)? $this->$name: null;
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
        if (isset($this->$name))
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
     */
    public function exchangeArray($data)
    {
        $caller = get_called_class();
        foreach ($data as $key => $value) {
            if (property_exists($caller, $key))
                $this->$key = $value;
        }
    }
}