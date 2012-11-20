<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model\Entity\UserInfo
 *
 * @ORM\Table(name="shop_user_info")
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
     * @var Model\Entity\Order[]
     * 
     * @ORM\OneToMany(targetEntity="Model\Entity\Order", mappedBy="userInfo")
     */
    protected $orders;    
    
    
    /**          
     * @var Model\Entity\User
     * 
     * @ORM\ManyToOne(targetEntity="Model\Entity\User", inversedBy="addresses")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id") 
     */
    protected $user;

    public function getFullName() 
    {
        return "{$this->lastName} {$this->firstName} {$this->middleName}";
    }
    
}
