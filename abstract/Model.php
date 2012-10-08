<?php

namespace Abstracts;

class Model
{
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

    private function getter($method)
    {          
        $name = $this->getPropertyName($method);
        return isset($this->$name)? $this->$name: null;
    }

    private function setter($method, $value)
    {
        $name = $this->getPropertyName($method);
        if (isset($this->$name))
            return $this->$name = $value;
        else
            return null;
    }
    
    private function getPropertyName($method)
    {
        $name = substr($method, 3); 
        $name[0] = strtolower($name[0]);
        return $name;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}