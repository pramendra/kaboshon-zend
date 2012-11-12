<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopOrders
 *
 * @ORM\Table(name="shop_orders")
 * @ORM\Entity
 */
class ShopOrders extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $orderId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \Model\Entity\ShopUserInfo
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\ShopUserInfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_info_id", referencedColumnName="user_info_id")
     * })
     */
    private $userInfo;


}
