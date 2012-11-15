<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopOrderItems
 *
 * @ORM\Table(name="shop_order_items")
 * @ORM\Entity
 */
class OrderItem extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="order_item_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderItemId;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var \Model\Entity\ShopOrders
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\ShopOrders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="order_id")
     * })
     */
    private $order;

    /**
     * @var \Model\Entity\ShopProducts
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\ShopProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;


}
