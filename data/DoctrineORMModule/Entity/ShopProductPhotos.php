<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopProductPhotos
 *
 * @ORM\Table(name="shop_product_photos")
 * @ORM\Entity
 */
class ShopProductPhotos extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="photo_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $photoId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=false)
     */
    private $file;

    /**
     * @var \ShopProducts
     *
     * @ORM\ManyToOne(targetEntity="ShopProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;


}
