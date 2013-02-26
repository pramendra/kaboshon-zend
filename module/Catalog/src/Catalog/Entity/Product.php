<?php

namespace Catalog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;
use Catalog\Entity\ProductPhoto;
use Catalog\Entity\Category;

/**
 * Catalog\Entity\Product
 *
 * @ORM\Table(name="shop_products")
 * @ORM\Entity(repositoryClass="Catalog\Repository\ProductRepository")
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
     * Main product photo, which shows in catalog
     * @var \Catalog\Entity\ProductPhoto
     */
    protected $mainPhoto;

    /**
     * Criteria for ProductPhoto[], for filter main photo
     * @var \Doctrine\Common\Collections\Criteria
     */
    static private $mainPhotoCriteria;

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

    public function getCategoryName()
    {
        return $this->category->getName();
    }

    public function getMainPhoto()
    {
        if ($this->mainPhoto)
            return $this->mainPhoto;

        if (!self::$mainPhotoCriteria)
            self::$mainPhotoCriteria = Criteria::create()
                ->where(Criteria::expr()->eq("main", true))
                ->setFirstResult(0)
                ->setMaxResults(1);

        $this->mainPhoto =  $this->getPhotos()->matching(self::$mainPhotoCriteria)->first();

        return $this->mainPhoto;
    }

    public function setMainPhoto(ProductPhoto $mainPhoto)
    {
        $this->mainPhoto = $mainPhoto;
        return $this;
    }
}
