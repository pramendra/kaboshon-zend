<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ShopGroups
 *
 * @ORM\Table(name="shop_groups")
 * @ORM\Entity
 */
class ShopGroups
{
    /**
     * @var integer $groupId
     *
     * @ORM\Column(name="group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $groupId;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer $discount
     *
     * @ORM\Column(name="discount", type="integer", nullable=true)
     */
    private $discount;


}
