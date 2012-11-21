<?php

namespace Album\Service;

use Abstracts\DomainService;

class Test extends DomainService
{
    public function t()
    {
        return $this->options['model'];
    }
            
}

