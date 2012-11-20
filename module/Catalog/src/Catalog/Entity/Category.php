<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Entity\Category
 *
 * @ORM\Table(name="shop_categories")
 * @ORM\Entity
 */
class Category extends \Abstracts\Entity
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string $descr
     *
     * @ORM\Column(name="descr", type="string", length=255, nullable=true)
     */
    protected $descr;

    /**
     * @var string $metaDescr
     *
     * @ORM\Column(name="meta_descr", type="string", length=255, nullable=true)
     */
    protected $metaDescr;

    /**
     * @var string $metaKeywords
     *
     * @ORM\Column(name="meta_keywords", type="string", length=255, nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var Model\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;
    
    /**
     * @var Model\Entity\Category[]
     * 
     * @ORM\OneToMany(targetEntity="Model\Entity\Category", mappedBy="parent")     
     */
    protected $children;
    
    /**     
     * @var Model\Entity\Product[]
     * 
     * @ORM\OneToMany(targetEntity="Model\Entity\Product", mappedBy="category")
     */
    protected $products;
        
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->children = new ArrayCollection();        
    }
}
