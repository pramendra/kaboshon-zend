<?php

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity 
 * @ORM\Table(name="products")
 **/
class Product extends \Abstracts\Entity
{
    /** 
     * @ORM\Id 
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue 
     **/    
    protected $id;
    /** 
     * @ORM\Column(type="string") 
     **/
    protected $name;
}
