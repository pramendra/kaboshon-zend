<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopOrderItems
 *
 * @ORM\Table(name="shop_order_items")
 * @ORM\Entity
 */
class ShopOrderItems
{
    /**
     * @var integer $orderItemId
     *
     * @ORM\Column(name="order_item_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderItemId;

    /**
     * @var integer $quantity
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var ShopOrders
     *
     * @ORM\ManyToOne(targetEntity="ShopOrders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="order_id")
     * })
     */
    private $order;

    /**
     * @var ShopProducts
     *
     * @ORM\ManyToOne(targetEntity="ShopProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;


}
