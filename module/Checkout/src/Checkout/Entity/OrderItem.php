<?php

namespace Checkout\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Entity\OrderItem
 *
 * @ORM\Table(name="shop_order_items")
 * @ORM\Entity
 */
class OrderItem extends \Abstracts\Entity
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
     * @var integer $quantity
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    protected $quantity;

    /**
     * @var Checkout\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="Checkout\Entity\Order", inversedBy="items")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @var Catalog\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Catalog\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
}
