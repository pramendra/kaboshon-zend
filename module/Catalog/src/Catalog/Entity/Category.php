<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Catalog\Entity\Category
 *
 * @ORM\Table(name="shop_categories")
 * @ORM\Entity(repositoryClass="Catalog\Repository\Category")
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
     * @ORM\Column(name="descr", type="string", length=100, nullable=true)
     */
    protected $descr;

    /**
     * @var string $metaDescr
     *
     * @ORM\Column(name="meta_descr", type="text", length=255, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\Category", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @var Catalog\Entity\Category[]
     *
     * @ORM\OneToMany(targetEntity="Catalog\Entity\Category", mappedBy="parent", cascade={"persist"})
     */
    protected $children;

    /**
     * @var Catalog\Entity\Product[]
     *
     * @ORM\OneToMany(targetEntity="Catalog\Entity\Product", mappedBy="category")
     */
    protected $products;

    public function __construt(Category $parent = null, $data = array())
    {
        $this->children = new ArrayCollection();
        parent::__construct($data);
    }

    public function getParentName()
    {
        $parent = $this->getParent();
        if ($parent === null)
            return null;
        else
            return $parent->getName();
    }
}
