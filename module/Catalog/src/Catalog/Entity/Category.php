<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Catalog\Entity\Category
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
     * @var Catalog\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;
    
    /**
     * @var Catalog\Entity\Category[]
     * 
     * @ORM\OneToMany(targetEntity="Catalog\Entity\Category", mappedBy="parent")     
     */
    protected $children;
    
    /**     
     * @var Catalog\Entity\Product[]
     * 
     * @ORM\OneToMany(targetEntity="Catalog\Entity\Product", mappedBy="category")
     */
    protected $products;
        
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->children = new ArrayCollection();        
    }
}
