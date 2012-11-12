<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopOrdersHistory
 *
 * @ORM\Table(name="shop_orders_history")
 * @ORM\Entity
 */
class ShopOrdersHistory extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderId;


}
