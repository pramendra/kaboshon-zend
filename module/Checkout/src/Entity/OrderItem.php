<?php

namespace Model\Entity;

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
     * @var Model\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\Order", inversedBy="items")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @var Model\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;
}
