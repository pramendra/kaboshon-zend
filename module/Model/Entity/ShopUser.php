<?php

namespace Model\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopUsers
 *
 * @ORM\Table(name="shop_users")
 * @ORM\Entity
 */
class User extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=16, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=129, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="permission", type="string", length=20, nullable=true)
     */
    private $permission;

    /**
     * @var \Model\Entity\ShopGroups
     *
     * @ORM\ManyToOne(targetEntity="Model\Entity\ShopGroups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="group_id", referencedColumnName="group_id")
     * })
     */
    private $group;


}
