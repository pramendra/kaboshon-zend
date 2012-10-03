<?php

namespace Abstracts;

class Model
{
    public function __call($name, $arguments)
    {
        switch (substr($name, 0, 2)) {

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

    private function getter($name)
    {
        return isset($this->$name)? $this->$name: null;
    }

    private function setter($name, $value)
    {
        if (isset($this->$name))
            return $this->$name = $value;
        else
            return null;
    }
}