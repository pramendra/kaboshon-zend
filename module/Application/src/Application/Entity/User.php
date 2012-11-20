<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Model\Entity\User
 *
 * @ORM\Table(name="shop_users")
 * @ORM\Entity
 */
class User extends \Abstracts\Entity
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
     * @var string $login
     *
     * @ORM\Column(name="login", type="string", length=16, nullable=false)
     */
    protected $login;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=false)
     */
    protected $password;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=254, nullable=false)
     */
    protected $email;

    /**
     * @var string $permission
     *
     * @ORM\Column(name="permission", type="string", length=50, nullable=true)
     */
    protected $permission;
    
    /**     
     * @var Model\Entity\UserInfo[]
     * 
     * @ORM\OneToMany(targetEntity="Model\Entity\UserInfo", mappedBy="user")
     */
    protected $addresses;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->addresses = new ArrayCollection;
    }
}
