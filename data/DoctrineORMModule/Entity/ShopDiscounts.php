<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopDiscounts
 *
 * @ORM\Table(name="shop_discounts")
 * @ORM\Entity
 */
class ShopDiscounts
{
    /**
     * @var integer $discountId
     *
     * @ORM\Column(name="discount_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $discountId;


}
