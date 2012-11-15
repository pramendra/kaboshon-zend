<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopProductPhotos
 *
 * @ORM\Table(name="shop_product_photos")
 * @ORM\Entity
 */
class ShopProductPhotos
{
    /**
     * @var integer $photoId
     *
     * @ORM\Column(name="photo_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $photoId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=false)
     */
    private $file;

    /**
     * @var integer $productId
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;


}
