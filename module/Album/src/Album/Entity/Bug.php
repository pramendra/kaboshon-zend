<?php

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Album\Repository\BugRepository")
 * @ORM\Table(name="bugs")
 **/
class Bug extends \Abstracts\Entity
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
    protected $description;
    /**
     * @ORM\Column(type="datetime")
     **/
    protected $created;
    /**
     * @ORM\Column(type="string")
     **/
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedBugs")
     **/
    protected $engineer;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reportedBugs")
     **/
    protected $reporter;

    /**
     * @ORM\ManyToMany(targetEntity="Product")
     **/
    protected $products;
    
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }       
    
    public function assignToProduct($product)
    {
        $this->products[] = $product;
    }
}
