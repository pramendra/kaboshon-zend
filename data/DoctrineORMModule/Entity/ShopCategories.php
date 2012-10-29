<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopCategories
 *
 * @ORM\Table(name="shop_categories")
 * @ORM\Entity
 */
class ShopCategories
{
    /**
     * @var integer $categoryId
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string $descr
     *
     * @ORM\Column(name="descr", type="string", length=255, nullable=true)
     */
    private $descr;

    /**
     * @var string $metaDescr
     *
     * @ORM\Column(name="meta_descr", type="string", length=255, nullable=true)
     */
    private $metaDescr;

    /**
     * @var string $metaKeywords
     *
     * @ORM\Column(name="meta_keywords", type="string", length=255, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var ShopCategories
     *
     * @ORM\ManyToOne(targetEntity="ShopCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="category_id")
     * })
     */
    private $parent;


}
