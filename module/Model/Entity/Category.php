<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopCategories
 *
 * @ORM\Table(name="shop_categories")
 * @ORM\Entity
 */
class Categories extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="string", length=255, nullable=true)
     */
    private $descr;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_descr", type="string", length=255, nullable=true)
     */
    private $metaDescr;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=255, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var \Model\Entity\ShopCategories
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\ShopCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="category_id")
     * })
     */
    private $parent;


}
