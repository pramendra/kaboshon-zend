<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Catalog\Entity\Product
 *
 * @ORM\Table(name="shop_products")
 * @ORM\Entity
 */
class Product extends \Abstracts\Entity
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
     * @var float $price
     *
     * @ORM\Column(name="price", type="decimal", nullable=false)
     */
    protected $price;

    /**
     * @var string $descr
     *
     * @ORM\Column(name="descr", type="text", nullable=true)
     */
    protected $descr;

    /**
     * @var \Catalog\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    
    /**     
     * @var \Catalog\Entity\ProductPhoto[]
     * 
     * @ORM\OneToMany(targetEntity="Catalog\Entity\ProductPhoto", mappedBy="product")
     */
    protected $photos;

    /**
     * @param Category $category
     * @param array $data
     */
    public function __construct(Category $category = null, $data = null)
    {
        if ($category)
            $this->setCategory($category);

        parent::__construct($data);
    }
}
