<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopProducts
 *
 * @ORM\Table(name="shop_products")
 * @ORM\Entity
 */
class ShopProducts extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    private $descr;

    /**
     * @var \Model\Entity\ShopCategories
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\ShopCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     * })
     */
    private $category;


}
