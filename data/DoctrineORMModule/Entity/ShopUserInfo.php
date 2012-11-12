<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopUserInfo
 *
 * @ORM\Table(name="shop_user_info")
 * @ORM\Entity
 */
class ShopUserInfo extends \Abstracts\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_info_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userInfoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=100, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=60, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="territory", type="string", length=100, nullable=true)
     */
    private $territory;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=60, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=true)
     */
    private $phone;


}
