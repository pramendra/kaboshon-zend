<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalog\Entity\ProductPhoto
 *
 * @ORM\Table(name="shop_product_photos")
 * @ORM\Entity
 */
class ProductPhoto extends \Abstracts\Entity
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=false)
     */
    protected $file;
    
    /**
     * @var bool $isMain
     *      
     * @ORM\Column(name="is_main", type="boolean", nullable=false)
     */
    protected $isMain = false;

    /**
     * @var Catalog\Entity\Product
     *     
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\Product", inversedBy="photos")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")         
     */
    protected $product;

}
