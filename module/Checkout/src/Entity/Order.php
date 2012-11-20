<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Entity\Order
 *
 * @ORM\Table(name="shop_orders")
 * @ORM\Entity
 */
class Order extends \Abstracts\Entity
{
    /**
     * @var integer $orderId
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    protected $status;

    /**
     * @var Profile\Entity\UserInfo
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\UserInfo", inversedBy="orders")
     * @ORM\JoinColumn(name="user_info_id", referencedColumnName="id")
     */
    protected $userInfo;
    
    /**     
     * @var Checkout\Entity\OrderItems[] 
     * 
     * @ORM\OneToMany(targetEntity="Model\Entity\OrderItem", mappedBy="order")   
     */
    protected $items;
    
    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->items = new ArrayCollection;
    }
}
