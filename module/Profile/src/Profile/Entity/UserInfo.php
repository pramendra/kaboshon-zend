<?php

namespace Profile\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Entity\UserInfo
 *
 * @ORM\Table(name="shop_user_infos")
 * @ORM\Entity
 */
class UserInfo extends \Abstracts\Entity
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
     * @var string $firstName
     *
     * @ORM\Column(name="first_name", type="string", length=100, nullable=false)
     */
    protected $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="last_name", type="string", length=100, nullable=true)
     */
    protected $lastName;

    /**
     * @var string $middleName
     *
     * @ORM\Column(name="middle_name", type="string", length=100, nullable=true)
     */
    protected $middleName;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    protected $address;

    /**
     * @var string $city
     *
     * @ORM\Column(name="city", type="string", length=60, nullable=false)
     */
    protected $city;

    /**
     * @var string $territory
     *
     * @ORM\Column(name="territory", type="string", length=100, nullable=true)
     */
    protected $territory;

    /**
     * @var string $country
     *
     * @ORM\Column(name="country", type="string", length=60, nullable=false)
     */
    protected $country;

    /**
     * @var string $phone
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=true)
     */
    protected $phone;

     /**
     * @var Checkout\Entity\Order[]
     *
     * @ORM\OneToMany(targetEntity="Checkout\Entity\Order", mappedBy="userInfo", cascade={"persist", "detach"})
     */
    protected $orders;

    /**
     * @var Application\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\User", inversedBy="userInfos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $user;

    public function getFullName()
    {
        return "{$this->lastName} {$this->firstName} {$this->middleName}";
    }

    public function __counstruct()
    {
        $this->orders = new ArrayCollection;
    }
}
